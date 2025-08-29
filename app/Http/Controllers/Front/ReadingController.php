<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Reading;
use Illuminate\View\View;

class ReadingController extends Controller
{
    const ROWS_PER_PAGE = 20;

    /**
     * Display a listing of the reading.
     */
    public function index(): View
    {
        $readings = Reading::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate(self::ROWS_PER_PAGE);

        $title = 'Readings';
        return view('front.reading.index', compact('readings', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::ROWS_PER_PAGE);
    }

    /**
     * Display the specified reading.
     */
    public function show(Reading $reading): View
    {
        return view('front.reading.show', compact('reading'));
    }
}
