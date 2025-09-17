<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\CompanyStoreRequest;
use App\Http\Requests\Career\CompanyUpdateRequest;
use App\Models\Career\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $perPage= $request->query('per_page', $this->perPage);

        $companies = Company::latest()->paginate($perPage);

        return view('admin.career.company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new company.
     *
     * @param Request $request
     * @return View
     */
    public function create(): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.company.create', compact('referer'));
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

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $company->name . ' created successfully.');
        } else {
            return redirect()->route('admin.career.company.index')
                ->with('success', $company->name . ' created successfully.');
        }
    }

    /**
     * Display the specified company.
     *
     * @param Company $commpany
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
     * @param Request $request
     * @return View
     */
    public function edit(Company $company): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.company.edit', compact('company', 'referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $company->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.career.company.index')
                ->with('success', $company->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified company from storage.
     *
     * @param Company $company
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Company $company, Request $request): RedirectResponse
    {
        $company->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $company->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.career.company.index')
                ->with('success', $company->name . ' deleted successfully');
        }
    }
}
