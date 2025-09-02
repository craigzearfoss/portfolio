<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\AcademyStoreRequest;
use App\Http\Requests\Portfolio\AcademyUpdateRequest;
use App\Models\Portfolio\Academy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademyController extends Controller
{
    /**
     * Display a listing of academies.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $academies = Academy::latest()->paginate($perPage);

        return view('admin.portfolio.academy.index', compact('academies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new academy.
     */
    public function create(): View
    {
        return view('admin.portfolio.academy.create');
    }

    /**
     * Store a newly created academy in storage.
     */
    public function store(AcademyStoreRequest $request): RedirectResponse
    {
        Academy::create($request->validated());

        return redirect()->route('admin.portfolio.academy.index')
            ->with('success', 'Academy created successfully.');
    }

    /**
     * Display the specified academy.
     */
    public function show(Academy $academy): View
    {
        return view('admin.portfolio.academy.show', compact('academy'));
    }

    /**
     * Show the form for editing the specified academy.
     */
    public function edit(Academy $academy): View
    {
        return view('admin.portfolio.academy.edit', compact('academy'));
    }

    /**
     * Update the specified academy in storage.
     */
    public function update(AcademyUpdateRequest $request, Academy $academy): RedirectResponse
    {
        $academy->update($request->validated());

        return redirect()->route('admin.portfolio.academy.index')
            ->with('success', 'Academy updated successfully');
    }

    /**
     * Remove the specified academy from storage.
     */
    public function destroy(Academy $academy): RedirectResponse
    {
        $academy->delete();

        return redirect()->route('admin.portfolio.academy.index')
            ->with('success', 'Academy deleted successfully');
    }
}
