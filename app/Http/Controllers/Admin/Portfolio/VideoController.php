<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\VideosExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreVideosRequest;
use App\Http\Requests\Portfolio\UpdateVideosRequest;
use App\Models\Portfolio\Video;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Video::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $videos = new Video()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Video::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Videos';

        return view('admin.portfolio.video.index', compact('videos', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new video.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Video::class, $this->admin);

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
        createGate(Video::class, $this->admin);

        $video = Video::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $video['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.video.show', $video)
                ->with('success', $video->name . ' successfully added.');
        }
    }

    /**
     * Display the specified video.
     *
     * @param Video $video
     * @return View
     */
    public function show(Video $video): View
    {
        readGate($video, $this->admin);

        list($prev, $next) = $video->prevAndNextPages(
            $video['id'],
            'admin.portfolio.video.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.video.show', compact('video', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param Video $video
     * @return View
     */
    public function edit(Video $video): View
    {
        updateGate($video, $this->admin);

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

        updateGate($video, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $video['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.video.show', $video)
                ->with('success', $video->name . ' successfully updated.');
        }
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @return RedirectResponse
     */
    public function destroy(Video $video): RedirectResponse
    {
        deleteGate($video, $this->admin);

        $video->delete();

        return redirect(referer('admin.portfolio.video.index'))
            ->with('success', $video->name . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Video::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'videos_' . date("Y-m-d-His") . '.xlsx'
            : 'videos.xlsx';

        return Excel::download(new VideosExport(), $filename);
    }
}
