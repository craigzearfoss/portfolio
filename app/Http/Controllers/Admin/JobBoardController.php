<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerJobBoardStoreRequest;
use App\Http\Requests\CareerJobBoardUpdateRequest;
use App\Models\Career\JobBoard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobBoardController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the job board.
     */
    public function index(): View
    {
        $jobBoards = JobBoard::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.job_board.index', compact('jobBoards'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new job board.
     */
    public function create(): View
    {
        return view('admin.job_board.create');
    }

    /**
     * Store a newly created job board in storage.
     */
    public function store(CareerJobBoardUpdateRequest $request): RedirectResponse
    {
        JobBoard::create($request->validated());

        return redirect()->route('admin.job_board.index')
            ->with('success', 'Cover letter created successfully.');
    }

    /**
     * Display the specified job board.
     */
    public function show(JobBoard $jobBoard): View
    {
        return view('admin.job_board.show', compact('jobBoard'));
    }

    /**
     * Show the form for editing the specified job board.
     */
    public function edit(JobBoard $jobBoard): View
    {
        return view('admin.job_board.edit', compact('jobBoard'));
    }

    /**
     * Update the specified job board in storage.
     */
    public function update(CareerJobBoardUpdateRequest $request, JobBoard $jobBoard): RedirectResponse
    {
        $jobBoard->update($request->validated());

        return redirect()->route('admin.job_board.index')
            ->with('success', 'Cover letter updated successfully');
    }

    /**
     * Remove the specified job board from storage.
     */
    public function destroy(JobBoard $jobBoard): RedirectResponse
    {
        $jobBoard->delete();

        return redirect()->route('admin.link.index')
            ->with('success', 'Cover letter deleted successfully');
    }
}
