<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerCompanyStoreRequest;
use App\Http\Requests\CareerCompanyUpdateRequest;
use App\Models\Career\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of companies.
     */
    public function index(): View
    {
        $companies = Company::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(): View
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(CareerCompanyStoreRequest $request): RedirectResponse
    {
        Company::create($request->validated());

        return redirect()->route('admin.company.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): View
    {
        return view('admin.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company): View
    {
        return view('admin.company.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(CareerCompanyUpdateRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return redirect()->route('admin.company.index')
            ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()->route('admin.company.index')
            ->with('success', 'Company deleted successfully');
    }
}
