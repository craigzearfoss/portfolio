<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Link;
use Illuminate\View\View;

class LinkController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the link.
     */
    public function index(): View
    {
        $links = Link::where('disabled', 0)->orderBy('seq')->paginate(self::NUM_PER_PAGE);

        return view('front.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }
}
