<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Art;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        return view('front.art.index', compact('arts', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified art.
     */
    public function show(Art $art): View
    {
        return view('front.art.show', compact('art'));
    }
}
