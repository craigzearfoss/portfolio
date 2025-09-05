<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ApplicationStoreRequest;
use App\Http\Requests\Career\ApplicationUpdateRequest;
use App\Models\Career\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends BaseController
{
    /**
     * Display a listing of applications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $applications = Application::latest()->paginate($perPage);

        return view('admin.career.application.index', compact('applications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new application.
     */
    public function create(): View
    {
        return view('admin.career.application.create');
    }

    /**
     * Store a newly created application in storage.
     */
    public function store(ApplicationStoreRequest $request): RedirectResponse
    {
        Application::create($request->validated());

        return redirect()->route('admin.career.application.index')
            ->with('success', 'Application created successfully.');
    }

    /**
     * Display the specified application.
     */
    public function show(Application $application): View
    {
        return view('admin.career.application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     */
    public function edit(Application $application): View
    {
        return view('admin.career.application.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     */
    public function update(ApplicationUpdateRequest $request, Application $application): RedirectResponse
    {
        $application->update($request->validated());

        return redirect()->route('admin.career.application.index')
            ->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified application from storage.
     */
    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.career.application.index')
            ->with('success', 'Application deleted successfully');
    }
}
