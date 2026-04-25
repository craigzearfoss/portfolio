<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\SkillsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSkillsRequest;
use App\Http\Requests\Portfolio\UpdateSkillsRequest;
use App\Models\Portfolio\Skill;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Skill::class, $this->admin);

        $perPage = 50; //$request->query('per_page', $this->perPage());

        $skills = new Skill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Skill::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Skills';

        return view('admin.portfolio.skill.index', compact('skills', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Skill::class, $this->admin);

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
        createGate(Skill::class, $this->admin);

        $skill = Skill::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $skill['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.skill.show', $skill)
                ->with('success', $skill['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function show(Skill $skill): View
    {
        readGate($skill, $this->admin);

        list($prev, $next) = $skill->prevAndNextPages(
            $skill['id'],
            'admin.portfolio.skill.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate($skill, $this->admin);

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

        updateGate($skill, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $skill['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.skill.show', $skill)
                ->with('success', $skill['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        deleteGate($skill, $this->admin);

        $skill->delete();

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'skills_' . date("Y-m-d-His") . '.xlsx'
            : 'skills.xlsx';

        return Excel::download(new SkillsExport(), $filename);
    }
}
