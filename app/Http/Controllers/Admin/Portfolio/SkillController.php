<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSkillsRequest;
use App\Http\Requests\Portfolio\UpdateSkillsRequest;
use App\Models\Portfolio\Skill;
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = 50; //$request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $skills = Skill::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $skills = Skill::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Skills' : $this->owner->name . ' Skills';

        return view('admin.portfolio.skill.index', compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return View
     */
    public function create(Request $request): View
    {
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
        list($prev, $next) = Skill::prevAndNextPages($skill->id,
            'admin.portfolio.skill.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.skill.show', compact('skill', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function edit(Skill $skill): View
    {
        if (!isRootAdmin() && ($skill->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $skill);

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
        if (!isRootAdmin() && ($skill->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $skill);

        $skill->delete();

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill->name . ' deleted successfully.');
    }
}
