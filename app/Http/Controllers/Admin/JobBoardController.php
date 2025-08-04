<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobBoardStoreRequest;
use App\Http\Requests\JobBoardUpdateRequest;
use App\Models\Career\JobBoard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobBoardController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the job board.
     */
    public function index(): View
    {
        $jobBoards = JobBoard::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.job-board.index', compact('jobBoards'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new job board.
     */
    public function create(): View
    {
        return view('admin.job-board.create');
    }

    /**
     * Store a newly created job board in storage.
     */
    public function store(JobBoardStoreRequest $request): RedirectResponse
    {
        JobBoard::create($request->validated());

        return redirect()->route('admin.job-board.index')
            ->with('success', 'Cover letter created successfully.');
    }

    /**
     * Display the specified job board.
     */
    public function show(JobBoard $jobBoard): View
    {
        return view('admin.job-board.show', compact('jobBoard'));
    }

    /**
     * Show the form for editing the specified job board.
     */
    public function edit(JobBoard $jobBoard): View
    {
        return view('admin.job-board.edit', compact('jobBoard'));
    }

    /**
     * Update the specified job board in storage.
     */
    public function update(JobBoardUpdateRequest $request, JobBoard $jobBoard): RedirectResponse
    {
        $jobBoard->update($request->validated());

        return redirect()->route('admin.job-board.index')
            ->with('success', 'Cover letter updated successfully');
    }

    /**
     * Remove the specified job board from storage.
     */
    public function destroy(JobBoard $jobBoard): RedirectResponse
    {
        $jobBoard->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Cover letter deleted successfully');
    }
}
