<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\JobBoardStoreRequest;
use App\Http\Requests\Career\JobBoardUpdateRequest;
use App\Models\Career\JobBoard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class JobBoardController extends BaseController
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.career.job-board.create', compact('referer'));
    }

    /**
     * Store a newly created job board in storage.
     *
     * @param JobBoardStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobBoardStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        $jobBoard =JobBoard::create($request->validated());

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $jobBoard->name . ' created successfully.');
        } else {
            return redirect()->route('admin.career.job-board.index')
                ->with('success', $jobBoard->name . '  created successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job boards.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.career.job-board.edit', compact('jobBoard', 'referer'));
    }

    /**
     * Update the specified job board in storage.
     *
     * @param JobBoardUpdateRequest $request
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function update(JobBoardUpdateRequest $request, JobBoard $jobBoard): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job boards.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('career_db.job_boards', 'slug') ] ]);
        $jobBoard->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $jobBoard->name . ' updated successfully.');
        } else {
        return redirect()->route('admin.career.job-board.index')
            ->with('success', $jobBoard->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified job board from storage.
     *
     * @param JobBoard $jobBoard
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(JobBoard $jobBoard, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job boards.');
        }

        $jobBoard->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $jobBoard->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.job-board.link.index')
                ->with('success', $jobBoard->name . ' deleted successfully.');
        }
    }
}
