<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSkillsRequest;
use App\Http\Requests\Portfolio\UpdateSkillsRequest;
use App\Models\Portfolio\Skill;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class SkillController extends BaseAdminController
{
    /**
     * Display a listing of skills.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'skill', $this->admin);

        $perPage = 50; //$request->query('per_page', $this->perPage());

        $skills = Skill::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Skills' : 'Skills';

        return view('admin.portfolio.skill.index', compact('skills', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'skill', $this->admin);

        return view('admin.portfolio.skill.create');
    }

    /**
     * Store a newly created skill in storage.
     *
     * @param StoreSkillsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSkillsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'skill', $this->admin);

        $skill = Skill::create($request->validated());

        return redirect()->route('admin.portfolio.skill.show', $skill)
            ->with('success', $skill->name . ' successfully added.');
    }

    /**
     * Display the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function show(Skill $skill): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $skill, $this->admin);

        list($prev, $next) = Skill::prevAndNextPages($skill->id,
            'admin.portfolio.skill.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.skill.show', compact('skill', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $skill = Skill::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $skill, $this->admin);

        return view('admin.portfolio.skill.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     *
     * @param UpdateSkillsRequest $request
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function update(UpdateSkillsRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $skill, $this->admin);

        return redirect()->route('admin.portfolio.skill.show', $skill)
            ->with('success', $skill->name . ' successfully updated.');
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $skill, $this->admin);

        $skill->delete();

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill->name . ' deleted successfully.');
    }
}
