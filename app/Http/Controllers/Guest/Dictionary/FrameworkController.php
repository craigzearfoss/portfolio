<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\FrameworkStoreRequest;
use App\Http\Requests\Dictionary\FrameworkUpdateRequest;
use App\Models\Dictionary\Framework;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class FrameworkController extends BaseController
{
    /**
     * Display a listing of frameworks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $frameworks = Framework::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('guest.dictionary.framework.index', compact('frameworks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified framework.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$framework = Framework::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.dictionary.framework.show', compact('framework'));
    }
}
