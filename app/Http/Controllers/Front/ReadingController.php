<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Reading;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReadingController extends Controller
{
    /**
     * Display a listing of readings.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $readings = Reading::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Readings';
        return view('front.reading.index', compact('readings', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified reading.
     */
    public function show(Reading $reading): View
    {
        return view('front.reading.show', compact('reading'));
    }
}
