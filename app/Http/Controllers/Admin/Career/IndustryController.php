<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\IndustryStoreRequest;
use App\Http\Requests\Career\IndustryUpdateRequest;
use App\Models\Career\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndustryController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of industries.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $industries = Industry::latest()->paginate($perPage);

        return view('admin.portfolio.industry.index', compact('industries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new industry.
     */
    public function create(): View
    {
        return view('admin.portfolio.industry.create');
    }

    /**
     * Store a newly created industry in storage.
     */
    public function store(IndustryStoreRequest $request): RedirectResponse
    {
        Industry::create($request->validated());

        return redirect()->route('admin.portfolio.industry.index')
            ->with('success', 'Industry created successfully.');
    }

    /**
     * Display the specified industry.
     */
    public function show(Industry $industry): View
    {
        return view('admin.portfolio.industry.show', compact('industry'));
    }

    /**
     * Show the form for editing the specified industry.
     */
    public function edit(Industry $industry): View
    {
        return view('admin.portfolio.industry.edit', compact('industry'));
    }

    /**
     * Update the specified industry in storage.
     */
    public function update(IndustryUpdateRequest $request, Industry $industry): RedirectResponse
    {
        $industry->update($request->validated());

        return redirect()->route('admin.portfolio.industry.index')
            ->with('success', 'Industry updated successfully');
    }

    /**
     * Remove the specified industry from storage.
     */
    public function destroy(Industry $industry): RedirectResponse
    {
        $industry->delete();

        return redirect()->route('admin.portfolio.industry.index')
            ->with('success', 'Industry deleted successfully');
    }
}
