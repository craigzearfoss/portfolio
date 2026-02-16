<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCoverLettersRequest;
use App\Http\Requests\Career\UpdateCoverLettersRequest;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CoverLetterController extends BaseAdminController
{
    /**
     * Display a listing of cover letters.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'cover-letter', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $coverLetters = CoverLetter::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($this->owner_id)) ? $this->owner->name . ' Cover Letters' : 'Cover Letters';

        return view('admin.career.cover-letter.index', compact('coverLetters', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new cover letter.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'cover-letter', $this->admin);

        return view('admin.career.cover-letter.create');
    }

    /**
     * Store a newly created cover letter in storage.
     *
     * @param StoreCoverLettersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCoverLettersRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'cover-letter', $this->admin);

        $coverLetter = new CoverLetter()->create($request->validated());

        return redirect()->route('admin.career.cover-letter.show', $coverLetter)
            ->with('success', 'Cover Letter successfully added.');
    }

    /**
     * Display the specified cover letter.
     *
     * @param CoverLetter $coverLetter
     * @return View
     */
    public function show(CoverLetter $coverLetter): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $coverLetter, $this->admin);

        list($prev, $next) = CoverLetter::prevAndNextPages($coverLetter->id,
            'admin.career.cover-letter.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.career.cover-letter.show', compact('coverLetter', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified cover letter.
     *
     * @param CoverLetter $coverLetter
     * @return View
     */
    public function edit(CoverLetter $coverLetter): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $coverLetter, $this->admin);

        return view('admin.career.cover-letter.edit', compact('coverLetter'));
    }

    /**
     * Update the specified cover letter in storage.
     *
     * @param UpdateCoverLettersRequest $request
     * @param CoverLetter $coverLetter
     * @return RedirectResponse
     */
    public function update(UpdateCoverLettersRequest $request,
                           CoverLetter               $coverLetter): RedirectResponse
    {
        $coverLetter->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $coverLetter, $this->admin);

        return redirect()->route('admin.career.cover-letter.show', $coverLetter)
            ->with('success', 'Cover letter successfully updated.');
    }

    /**
     * Remove the specified cover letter from storage.
     *
     * @param CoverLetter $coverLetter
     * @return RedirectResponse
     */
    public function destroy(CoverLetter $coverLetter): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $coverLetter, $this->admin);

        $coverLetter->delete();

        return redirect(referer('admin.career.cover-letter.index'))
            ->with('success', 'Cover letter deleted successfully.');
    }
}
