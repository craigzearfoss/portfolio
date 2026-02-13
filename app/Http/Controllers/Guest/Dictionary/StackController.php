<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Stack;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class StackController extends BaseGuestController
{
    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $stacks = Stack::where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.dictionary.stack.index'), compact('stacks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified stack.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$stack = Stack::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.stack.show'), compact('stack'));
    }
}
