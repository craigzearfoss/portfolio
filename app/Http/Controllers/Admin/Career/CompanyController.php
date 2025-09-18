<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\CompanyStoreRequest;
use App\Http\Requests\Career\CompanyUpdateRequest;
use App\Models\Career\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CompanyController extends BaseController
{
    /**
     * Display a listing of companies.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $companies = Company::latest()->paginate($perPage);

        return view('admin.career.company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new company.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.company.create');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CompanyStoreRequest $request): RedirectResponse
    {
        $company = Company::create($request->validated());

        return redirect(referer('admin.career.company.index'))
            ->with('success', $company->name . ' created successfully.');
    }

    /**
     * Display the specified company.
     *
     * @param Company $company
     * @return View
     */
    public function show(Company $company): View
    {
        return view('admin.career.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param Company $company
     * @return View
     */
    public function edit(Company $company): View
    {
        return view('admin.career.company.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     *
     * @param CompanyUpdateRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(CompanyUpdateRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return redirect(referer('admin.career.company.index'))
            ->with('success', $company->name . ' updated successfully.');
    }

    /**
     * Remove the specified company from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect(referer('admin.career.company.index'))
            ->with('success', $company->name . ' deleted successfully.');
    }
}
