<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Reading;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReadingController extends BaseController
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
            ->orderBy('title', 'asc')
            ->paginate($perPage);

        $title = 'Readings';
        return view('front.reading.index', compact('readings', 'title'))
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

        return view('front.reading.show', compact('reading'));
    }
}
