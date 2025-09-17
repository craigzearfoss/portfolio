<?php

namespace App\Http\Controllers\Front\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\StackStoreRequest;
use App\Http\Requests\Dictionary\StackUpdateRequest;
use App\Models\Dictionary\Stack;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class StackController extends BaseController
{
    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $stacks = Stack::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('front.dictionary.stack.index', compact('stacks'))
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

        return view('front.dictionary.stack.show', compact('stack'));
    }
}
