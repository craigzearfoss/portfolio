<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Link;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class LinkController extends BaseController
{
    /**
     * Display a listing of links.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

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
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$link = Link::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('link.show', compact('link'));
    }
}
