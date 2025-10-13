<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Audio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AudioController extends BaseGuestController
{
    /**
     * Display a listing of audios.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $audios = Audio::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.audio.index'), compact('audios'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified audio.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$audio = Audio::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.audio.show'), compact('audio'));
    }
}
