<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Art;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ArtController extends BaseController
{
    /**
     * Display a listing of art.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $arts = Art::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Art';
        return view('front.portfolio.art.index', compact('arts', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified art.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$art = Art::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('front.portfolio.art.show', compact('art'));
    }
}
