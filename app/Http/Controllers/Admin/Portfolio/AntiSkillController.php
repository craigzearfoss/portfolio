<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\EnvTypes;
use App\Exports\Portfolio\AntiSkillsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAntiSkillsRequest;
use App\Http\Requests\Portfolio\UpdateAntiSkillsRequest;
use App\Models\Portfolio\AntiSkill;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class AntiSkillController extends BaseAdminController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::ADMIN);

        view()->share('resourceType', 'portfolio.anti_skill');
    }

    /**
     * Display a listing of anti-skills.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(AntiSkill::class, $this->admin);

        $perPage = 50; //$request->query('per_page', $this->perPage());

        $antiSkills = new AntiSkill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AntiSkill::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Anti-Skills';

        return view('admin.portfolio.anti-skill.index', compact('antiSkills', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new anti-skill.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(AntiSkill::class, $this->admin);

        return view('admin.portfolio.anti-skill.create');
    }

    /**
     * Store a newly created anti-skill in storage.
     *
     * @param StoreAntiSkillsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAntiSkillsRequest $request): RedirectResponse
    {
        createGate(AntiSkill::class, $this->admin);

        $antiSkill = AntiSkill::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $antiSkill['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.anti-skill.show', $antiSkill)
                ->with('success', $antiSkill['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified anti-skill.
     *
     * @param AntiSkill $antiSkill
     * @return View
     */
    public function show(AntiSkill $antiSkill): View
    {
        readGate($antiSkill, $this->admin);

        list($prev, $next) = $antiSkill->prevAndNextPages(
            $antiSkill['id'],
            'admin.portfolio.anti-skill.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.anti-skill.show', compact('antiSkill', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified anti-skill.
     *
     * @param AntiSkill $antiSkill
     * @return View
     */
    public function edit(AntiSkill $antiSkill): View
    {
        updateGate($antiSkill, $this->admin);

        return view('admin.portfolio.anti-skill.edit', compact('antiSkill'));
    }

    /**
     * Update the specified anti-skill in storage.
     *
     * @param UpdateAntiSkillsRequest $request
     * @param AntiSkill $antiSkill
     * @return RedirectResponse
     */
    public function update(UpdateAntiSkillsRequest $request, AntiSkill $antiSkill): RedirectResponse
    {
        $antiSkill->update($request->validated());

        updateGate($antiSkill, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $antiSkill['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.anti-skill.show', $antiSkill)
                ->with('success', $antiSkill['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified anti-skill from storage.
     *
     * @param AntiSkill $antiSkill
     * @return RedirectResponse
     */
    public function destroy(AntiSkill $antiSkill): RedirectResponse
    {
        deleteGate($antiSkill, $this->admin);

        $antiSkill->delete();

        return redirect(referer('admin.portfolio.anti-skill.index'))
            ->with('success', $antiSkill['name'] . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(AntiSkill::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'anti_skills_' . date("Y-m-d-His") . '.xlsx'
            : 'anti_skills.xlsx';

        return Excel::download(new AntiSkillsExport(), $filename);
    }
}
