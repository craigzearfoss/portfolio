<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreMusicRequest;
use App\Http\Requests\Portfolio\UpdateMusicRequest;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class MusicController extends BaseAdminController
{
    /**
     * Display a listing of music.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'music', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $musics = Music::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $musics = Music::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Music' : $this->owner->name . ' music';

        return view('admin.portfolio.music.index', compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new music.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'music', $this->admin);

        return view('admin.portfolio.music.create');
    }

    /**
     * Store a newly created music in storage.
     *
     * @param StoreMusicRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMusicRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'music', $this->admin);

        $music = Music::create($request->validated());

        return redirect()->route('admin.portfolio.music.show', $music)
            ->with('success', $music->name . ' successfully added.');
    }

    /**
     * Display the specified music.
     *
     * @param Music $music
     * @return View
     */
    public function show(Music $music): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $music, $this->admin);

        list($prev, $next) = Music::prevAndNextPages($music->id,
            'admin.portfolio.music.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.music.show', compact('music', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified music.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $music = Music::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $music, $this->admin);

        return view('admin.portfolio.music.edit', compact('music'));
    }

    /**
     * Update the specified music in storage.
     *
     * @param UpdateMusicRequest $request
     * @param Music $music
     * @return RedirectResponse
     */
    public function update(UpdateMusicRequest $request, Music $music): RedirectResponse
    {
        $music->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $music, $this->admin);

        return redirect()->route('admin.portfolio.music.show', $music)
            ->with('success', $music->name . ' successfully updated.');
    }

    /**
     * Remove the specified music from storage.
     *
     * @param Music $music
     * @return RedirectResponse
     */
    public function destroy(Music $music): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $music, $this->admin);

        $music->delete();

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' deleted successfully.');
    }
}
