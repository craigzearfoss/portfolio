<?php

namespace App\Http\Controllers\Admin\System;

use App\Models\System\MenuItem;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreMenuItemsRequest;
use App\Http\Requests\System\UpdateMenuItemsRequest;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends BaseAdminController
{
    /**
     * Display a listing of menu items.
     *
     * @param string $envType
     * @return View
     */
    public function index(string | null $envType = 'admin'): View
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
                $menuItems = MenuItem::where('guest', 1)
                    ->orderBy('sequence', 'asc')
                    //->orderBy('parent_id', 'asc')
                    ->orderBy('level', 'asc')
                    ->get();
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
        return view('admin.system.menu-item.create');
    }

    /**
     * Store a newly created menu item in storage.
     *
     * @param StoreMenuItemsRequest $storeMenuItemsRequest
     * @return RedirectResponse
     */
    public function store(StoreMenuItemsRequest $storeMenuItemsRequest): RedirectResponse
    {
        $menuItem = MenuItem::create($storeMenuItemsRequest->validated());

        return redirect()->route('admin.system.menu-item.show', $menuItem)
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
        return view('admin.system.menu-item.edit', compact('menuItem'));
    }

    /**
     * Update the specified menu item in storage.
     *
     * @param UpdateMenuItemsRequest $updateMenuItemsRequest
     * @param MenuItem $menuItem
     * @return RedirectResponse
     */
    public function update(UpdateMenuItemsRequest $updateMenuItemsRequest, MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update($updateMenuItemsRequest->validated());

        return redirect(referer('admin.system.menu-item.index'))
            ->with('success', $menuItem->name . ' menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from storage.
     *
     * @param MenuItem $menuItem
     * @return RedirectResponse
     */
    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return redirect(referer('admin.system.menu-item.index'))
            ->with('success', $menuItem->name . ' menu item deleted successfully.');
    }
}
