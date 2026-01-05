<?php

namespace App\Http\Controllers\Admin\System;

use App\Models\System\MenuItem;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreMenuItemsRequest;
use App\Http\Requests\System\UpdateMenuItemsRequest;
use App\Services\PermissionService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends BaseAdminController
{
    /**
     * Display a listing of menu items.
     *
     * @param string|null $envType
     * @return View
     */
    public function index(string|null $envType = 'guest'): View
    {
        if (!in_array($envType, PermissionService::ENV_TYPES)) {

            session()->flash('error', 'Invalid env type \'' . $envType . '\' specified.');

            $menuItems = [];
            return view('admin.system.menu-item.index', compact('envType', 'menuItems'));

        } else {

            if (!empty($dbMenuItem->admin)) {
                $menuItems = MenuItem::where('admin', 1)
                    ->orderBy('sequence', 'asc')
                    //->orderBy('parent_id', 'asc')
                    ->orderBy('level', 'asc')
                    ->get();
            } elseif (!empty($dbMenuItem->user)) {
                $menuItems = MenuItem::where('user', 1)
                    ->orderBy('sequence', 'asc')
                    //->orderBy('parent_id', 'asc')
                    ->orderBy('level', 'asc')
                    ->get();
            } else {
                $menuItems = MenuItem::getGuestMenuItems();
                /*
                $menuItems = MenuItem::where('guest', 1)
                    ->orderBy('sequence', 'asc')
                    //->orderBy('parent_id', 'asc')
                    ->orderBy('level', 'asc')
                    ->get();
                */
            }

            return view('admin.system.menu-item.index', compact('envType', 'menuItems'));
        }
    }

    /**
     * Show the form for creating a new menu item.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.menu-item.create');
    }

    /**
     * Store a newly created menu item in storage.
     *
     * @param StoreMenuItemsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMenuItemsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can add new menu items.');
        }

        $menuItem = MenuItem::create($request->validated());

        return redirect()->route('admin.system.menu-item.index')
            ->with('success', $menuItem->name . ' menu item successfully added.');
    }

    /**
     * Display the specified menu item.
     *
     * @param MenuItem $menuItem
     * @return View
     */
    public function show(MenuItem $menuItem): View
    {
        return view('admin.system.menu-item.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified menu item.
     *
     * @param MenuItem $menuItem
     * @return View
     */
    public function edit(MenuItem $menuItem): View
    {
        Gate::authorize('update-resource', $menuItem);

        return view('admin.system.menu-item.edit', compact('menuItem'));
    }

    /**
     * Update the specified menu item in storage.
     *
     * @param UpdateMenuItemsRequest $request
     * @param MenuItem $menuItem
     * @return RedirectResponse
     */
    public function update(UpdateMenuItemsRequest $request, MenuItem $menuItem): RedirectResponse
    {
        Gate::authorize('update-resource', $menuItem);

        $menuItem->update($request->validated());

        return redirect()->route('admin.system.menu-item.index')
            ->with('success', $menuItem->name . ' menu item successfully updated.');
    }

    /**
     * Remove the specified menu item from storage.
     *
     * @param MenuItem $menuItem
     * @return RedirectResponse
     */
    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        Gate::authorize('delete-resource', $menuItem);

        $menuItem->delete();

        return redirect(referer('admin.system.menu-item.index'))
            ->with('success', $menuItem->name . ' menu item deleted successfully.');
    }
}
