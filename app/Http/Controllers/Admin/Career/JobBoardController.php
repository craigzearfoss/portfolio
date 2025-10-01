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
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        return view('admin.career.job-board.create');
    }

    /**
     * Store a newly created job board in storage.
     *
     * @param JobBoardStoreRequest $jobBoardStoreRequest
     * @return RedirectResponse
     */
    public function store(JobBoardStoreRequest $jobBoardStoreRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job boards.');
        }

        $jobBoard =JobBoard::create($jobBoardStoreRequest->validated());

        return redirect(referer('admin.career.job-board.index'))
            ->with('success', $jobBoard->name . ' added successfully.');
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

        return view('admin.career.job-board.edit', compact('jobBoard'));
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

        $jobBoard->update($request->validated());

        return redirect(referer('admin.career.job-board.index'))
            ->with('success', $jobBoard->name . ' updated successfully.');
    }

    /**
     * Remove the specified job board from storage.
     *
     * @param JobBoard $jobBoard
     * @return RedirectResponse
     */
    public function destroy(JobBoard $jobBoard): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job boards.');
        }

        $jobBoard->delete();

        return redirect(referer('admin.career.job-board.index'))
            ->with('success', $jobBoard->name . ' deleted successfully.');
    }
}
