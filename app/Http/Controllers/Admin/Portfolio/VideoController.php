<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreVideosRequest;
use App\Http\Requests\Portfolio\UpdateVideosRequest;
use App\Models\Portfolio\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class VideoController extends BaseAdminController
{
    /**
     * Display a listing of videos.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'video', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $videos = Video::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $videos = Video::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Videos' : $this->owner->name . ' videos';

        return view('admin.portfolio.video.index', compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new video.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'video', $this->admin);

        return view('admin.portfolio.video.create');
    }

    /**
     * Store a newly created video in storage.
     *
     * @param StoreVideosRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVideosRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'video', $this->admin);

        $video = Video::create($request->validated());

        return redirect()->route('admin.portfolio.video.show', $video)
            ->with('success', $video->name . ' successfully added.');
    }

    /**
     * Display the specified video.
     *
     * @param Video $video
     * @return View
     */
    public function show(Video $video): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $video, $this->admin);

        list($prev, $next) = Video::prevAndNextPages($video->id,
            'admin.portfolio.video.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.video.show', compact('video', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $video = Video::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $video, $this->admin);

        return view('admin.portfolio.video.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     *
     * @param UpdateVideosRequest $request
     * @param Video $video
     * @return RedirectResponse
     */
    public function update(UpdateVideosRequest $request, Video $video): RedirectResponse
    {
        $video->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $video, $this->admin);

        return redirect()->route('admin.portfolio.video.show', $video)
            ->with('success', $video->name . ' successfully updated.');
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @return RedirectResponse
     */
    public function destroy(Video $video): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $video, $this->admin);

        $video->delete();

        return redirect(referer('admin.portfolio.video.index'))
            ->with('success', $video->name . ' deleted successfully.');
    }
}
