<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Stack;
use App\Services\PermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class StackController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'dictionary.stack');
    }

    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $stacks = Stack::query()->where('name', '!=', 'other')
            ->where('is_public', '=', true)
            ->where('is_disabled', '=', false)
            ->where('name', '!=', 'other')
            ->orderBy('name')
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
        if (!$stack = Stack::query()->where('slug', '=', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.stack.show'), compact('stack'));
    }
}
