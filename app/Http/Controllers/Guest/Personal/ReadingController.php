<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Personal\Reading;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ReadingController extends BaseGuestController
{
    /**
     * Display a listing of readings.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $readings = Reading::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('title', 'asc')->orderBy('author', 'asc')
            ->paginate($perPage);

        $title = 'Readings';
        return view('guest.personal.reading.index', compact('readings', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified reading.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$reading = Reading::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.personal.reading.show', compact('reading'));
    }
}
