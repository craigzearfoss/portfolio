<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreJobBoardsRequest;
use App\Http\Requests\Career\UpdateJobBoardsRequest;
use App\Models\Career\JobBoard;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobBoardController extends BaseAdminController
{
    /**
     * Display a listing of job boards.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(JobBoard::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobBoards = new JobBoard()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobBoard::SEARCH_ORDER_BY)
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Job Boards';

        return view('admin.career.job-board.index', compact('jobBoards', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job board.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(JobBoard::class, $this->admin);

        return view('admin.career.job-board.create');
    }

    /**
     * Store a newly created job board in storage.
     *
     * @param StoreJobBoardsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobBoardsRequest $request): RedirectResponse
    {
        createGate(JobBoard::class, $this->admin);

        $jobBoard = JobBoard::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $jobBoard['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.career.job-board.show', $jobBoard)
                ->with('success', $jobBoard['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified job board.
     *
     * @param JobBoard $jobBoard
     * @return View
     */
    public function show(JobBoard $jobBoard): View
    {
        readGate($jobBoard, $this->admin);

        list($prev, $next) = $jobBoard->prevAndNextPages(
            $jobBoard['id'],
            'admin.career.job-board.show',
            null,
            [ 'name', 'asc' ]
        );

        return view('admin.career.job-board.show', compact('jobBoard', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job board.
     *
     * @param JobBoard $jobBoard
     * @return View
     */
    public function edit(JobBoard $jobBoard): View
    {
        updateGate($jobBoard, $this->admin);

        return view('admin.career.job-board.edit', compact('jobBoard'));
    }

    /**
     * Update the specified job board in storage.
     *
     * @param UpdateJobBoardsRequest $request
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function update(UpdateJobBoardsRequest $request, JobBoard $jobBoard): RedirectResponse
    {
        $jobBoard->update($request->validated());

        updateGate($jobBoard, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $jobBoard['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.career.job-board.show', $jobBoard)
                ->with('success', $jobBoard['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified job board from storage.
     *
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function destroy(JobBoard $jobBoard): RedirectResponse
    {
        deleteGate($jobBoard, $this->admin);

        $jobBoard->delete();

        return redirect(referer('admin.career.job-board.index'))
            ->with('success', $jobBoard['name'] . ' deleted successfully.');
    }
}
