<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Reading;
use Illuminate\View\View;

class ReadingController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of the reading.
     */
    public function index(): View
    {
        $readings = Reading::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($this->numPerPage);

        $title = 'Readings';
        return view('front.reading.index', compact('readings', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Display the specified reading.
     */
    public function show(Reading $reading): View
    {
        return view('front.reading.show', compact('reading'));
    }
}
