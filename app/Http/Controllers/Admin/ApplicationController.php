<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerApplicationStoreRequest;
use App\Http\Requests\CareerApplicationUpdateRequest;
use App\Models\Career\Application;
use App\Models\Career\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the application.
     */
    public function index(): View
    {
        $applications = Application::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.application.index', compact('applications'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new application.
     */
    public function create(): View
    {
        return view('admin.application.create');
    }

    /**
     * Store a newly created application in storage.
     */
    public function store(CareerApplicationStoreRequest $request): RedirectResponse
    {
        Application::create($request->validated());

        return redirect()->route('admin.application.index')
            ->with('success', 'Application created successfully.');
    }

    /**
     * Display the specified application.
     */
    public function show(Application $application): View
    {
        return view('admin.application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     */
    public function edit(Application $application): View
    {
        return view('admin.application.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     */
    public function update(CareerApplicationUpdateRequest $request, Application $application): RedirectResponse
    {
        $application->update($request->validated());

        return redirect()->route('admin.application.index')
            ->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified application from storage.
     */
    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.application.index')
            ->with('success', 'Application deleted successfully');
    }
}
