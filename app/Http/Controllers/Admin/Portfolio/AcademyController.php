<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAcademiesRequest;
use App\Http\Requests\Portfolio\UpdateAcademiesRequest;
use App\Models\Portfolio\Academy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AcademyController extends BaseAdminController
{
    /**
     * Display a listing of academies.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(Academy::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $academies = new Academy()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Academy::SEARCH_ORDER_BY)
        )
        ->where('name', '!=', 'other')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Academies';

        return view('admin.portfolio.academy.index', compact('academies', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new academy.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Academy::class, $this->admin);

        return view('admin.portfolio.academy.create');
    }

    /**
     * Store a newly created academy in storage.
     *
     * @param StoreAcademiesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAcademiesRequest $request): RedirectResponse
    {
        createGate(Academy::class, $this->admin);

        $academy = Academy::query()->create($request->validated());

        return redirect()->route('admin.portfolio.academy.show', $academy)
            ->with('success', $academy['name'] . ' successfully added.');
    }

    /**
     * Display the specified academy.
     *
     * @param Academy $academy
     * @return View
     */
    public function show(Academy $academy): View
    {
        readGate($academy, $this->admin);

        list($prev, $next) = $academy->prevAndNextPages(
            $academy['id'],
            'admin.portfolio.academy.show',
            null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.academy.show', compact('academy', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified academy.
     *
     * @param Academy $academy
     * @return View
     */
    public function edit(Academy $academy): View
    {
        updateGate($academy, $this->admin);

        return view('admin.portfolio.academy.edit', compact('academy'));
    }

    /**
     * Update the specified academy in storage.
     *
     * @param UpdateAcademiesRequest $request
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function update(UpdateAcademiesRequest $request, Academy $academy): RedirectResponse
    {
        $academy->update($request->validated());

        updateGate($academy, $this->admin);

        return redirect()->route('admin.portfolio.academy.show', $academy)
            ->with('success', $academy['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified academy from storage.
     *
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function destroy(Academy $academy): RedirectResponse
    {
        deleteGate($academy, $this->admin);

        $academy->delete();

        return redirect(route('admin.portfolio.academy.index'))
            ->with('success', $academy['name'] . ' deleted successfully.');
    }
}
