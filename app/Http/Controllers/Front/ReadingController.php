<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Reading;
use Illuminate\View\View;

class ReadingController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the reading.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
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
