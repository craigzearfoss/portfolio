<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\OperatingSystem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class OperatingSystemController extends BaseGuestController
{
    /**
     * Display a listing of operations systems.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $operatingSystems = OperatingSystem::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.dictionary.operating-system.index'), compact('operatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified operating system.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$operatingSystem = OperatingSystem::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.operating-system.show'), compact('operatingSystem'));
    }
}
