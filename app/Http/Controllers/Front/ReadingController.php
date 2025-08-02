<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Reading;
use Illuminate\View\View;

class ReadingController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the reading.
     */
    public function index(): View
    {
        $readings = Reading::where('disabled', 0)->orderBy('seq')->paginate(self::NUM_PER_PAGE);

        $title = 'Readings';
        return view('front.reading.index', compact('readings', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }
}
