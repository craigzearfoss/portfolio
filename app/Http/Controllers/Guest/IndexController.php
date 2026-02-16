<?php

namespace App\Http\Controllers\Guest;

use App\Models\System\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Guest index (home) page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $adminModel = new Admin();

        $admin = null;
        $admins = $adminModel->where('public', 1)
            ->where('disabled', false)
            ->orderBy('name')->paginate($perPage)->appends(request()->except('page'));

        if ($featuredUsername = config('app.featured_admin')) {
            $featuredAdmin = $adminModel->where('username', $featuredUsername)->first();
        } else {
            $featuredAdmin = null;
        }

        return view(themedTemplate('system.index'), compact('admin', 'admins', 'featuredAdmin'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Guest candidates home page.
     *
     * @param Request $request
     * @return View
     */
    public function candidates(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $admin = null;
        $candidates = new Admin()->where('public', 1)
            ->where('disabled', false)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.system.admin.index'), compact('admin', 'candidates'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
