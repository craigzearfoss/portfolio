<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Link;
use Illuminate\View\View;

class LinkController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the link.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $links = Link::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Links';
        return view('front.link.index', compact('links', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified link.
     */
    public function show(Link $link): View
    {
        return view('link.show', compact('link'));
    }
}
