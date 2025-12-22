<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreJobBoardsRequest;
use App\Http\Requests\Career\UpdateJobBoardsRequest;
use App\Models\Career\JobBoard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $jobBoards = JobBoard::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.job-board.index', compact('jobBoards'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job board.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        return view('admin.career.job-board.create');
    }

    /**
     * Store a newly created job board in storage.
     *
     * @param StoreJobBoardsRequest $storeJobBoardsRequest
     * @return RedirectResponse
     */
    public function store(StoreJobBoardsRequest $storeJobBoardsRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        $jobBoard =JobBoard::create($storeJobBoardsRequest->validated());

        return redirect()->route('admin.career.job-board.show', $jobBoard)
            ->with('success', $jobBoard->name . ' successfully added.');
    }

    /**
     * Display the specified job board.
     *
     * @param JobBoard $jobBoard
     * @return View
     */
    public function show(JobBoard $jobBoard): View
    {
        return view('admin.career.job-board.show', compact('jobBoard'));
    }

    /**
     * Show the form for editing the specified job board.
     *
     * @param JobBoard $jobBoard
     * @param Request $request
     * @return View
     */
    public function edit(JobBoard $jobBoard, Request $request): View
    {
        Gate::authorize('update-resource', $jobBoard);

        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit job boards.');
        }

        return view('admin.career.job-board.edit', compact('jobBoard'));
    }

    /**
     * Update the specified job board in storage.
     *
     * @param UpdateJobBoardsRequest $updateJobBoardsRequest
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function update(UpdateJobBoardsRequest $updateJobBoardsRequest, JobBoard $jobBoard): RedirectResponse
    {
        Gate::authorize('update-resource', $jobBoard);

        $jobBoard->update($updateJobBoardsRequest->validated());

        return redirect()->route('admin.career.job-board.show', $jobBoard)
            ->with('success', $jobBoard->name . ' successfully updated.');
    }

    /**
     * Remove the specified job board from storage.
     *
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function destroy(JobBoard $jobBoard): RedirectResponse
    {
        Gate::authorize('delete-resource', $jobBoard);

        $jobBoard->delete();

        return redirect(referer('admin.career.job-board.index'))
            ->with('success', $jobBoard->name . ' deleted successfully.');
    }
}
