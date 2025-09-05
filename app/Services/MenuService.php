<?php

namespace App\Services;

use App\Models\Database;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use stdClass;

class MenuService
{
    public function getLeftMenu()
    {
        $menu = [];
        foreach (Database::orderBy('sequence', 'asc')->get()->all() as $database) {
            if (!empty($database->resources)) {

                // Create menu item.
                $routeName = 'admin.'.$database->name.'.index';

                $menuItem = $this->createMenuItem($database);
                if ($database->property === 'db') {
                    $menuItem->title = 'System';

                } else {
                    $menuItem->link  = route($routeName);
                }
                $menuItem->active = $routeName == Route::currentRouteName() ? true : false;

                // Add children to menu item.
                foreach ($database->resources as $resource) {

                    $routeName = $database->property !== 'db'
                        ? 'admin.'.$database->name.'.'.$resource->type.'.index'
                        : 'admin.'.$resource->type.'.index';

                    $menuSubItem = $this->createMenuItem($database, $resource);
                    $menuSubItem->link    = route($routeName);
                    $menuSubItem->active = $routeName == Route::currentRouteName() ? true : false;
                    $menuItem->children[] = $menuSubItem;
                }

                // Add menu item to menu array.
                $menu[] = $menuItem;
            }
        }

        if (Auth::guard('admin')->check()) {

            $menuItem = $this->createMenuItem();
            $menuItem->title  = 'Profile';
            $menuItem->link   = route('admin.profile.show');
            $menuItem->active = 'admin.profile.show' == Route::currentRouteName() ? true : false;
            $menu[] = $menuItem;

            $menuItem = $this->createMenuItem();
            $menuItem->title  = 'Change Password';
            $menuItem->link   = route('admin.profile.change-password');
            $menuItem->active = 'admin.profile.change-password' == Route::currentRouteName() ? true : false;
            $menu[] = $menuItem;

            $menuItem = $this->createMenuItem();
            $menuItem->title = 'Logout';
            $menuItem->link  = route('admin.logout');
            $menu[] = $menuItem;

            if (Auth::guard('admin')->user()->root) {

                for ($i=0; $i<count($menu); $i++) {
                    if ($menu[$i]->database_property === 'db') {

                        $menuItem = $this->createMenuItem();
                        $menuItem->title  = 'Databases';
                        $menuItem->link   = route('admin.database.index');
                        $menuItem->active = 'admin.database.index' == Route::currentRouteName() ? true : false;
                        $menu[$i]->children[] = $menuItem;

                        $menuItem = $this->createMenuItem();
                        $menuItem->title  = 'Resources';
                        $menuItem->link   = route('admin.resource.index');
                        $menuItem->active = 'admin.resource.index' == Route::currentRouteName() ? true : false;
                        $menu[$i]->children[] = $menuItem;
                    }
                }
            }

        } elseif (Auth::guard('web')->check()) {

            $menuItem = $this->createMenuItem();
            $menuItem->title  = 'Profile';
            $menuItem->link   = route('profile.show');
            $menuItem->active = $routeName == Route::currentRouteName() ? true : false;
            $menu[] = $menuItem;

        } else {

        }
//dd($menu);
        return $menu;
    }

    public function getTopMenu()
    {

    }

    protected function createMenuItem($database = null, $resource = null)
    {
        $menuItem = new stdClass();
        $menuItem->database_id       = $database->id ?? null;
        $menuItem->database_name     = $database->name ?? null;
        $menuItem->database_property = $database->property ?? null;
        $menuItem->title             = $database->title ?? '';
        $menuItem->icon              = $database->icon ?? null;
        $menuItem->sequence          = $database->sequence ?? 0;
        $menuItem->public            = $database->public ?? 1;
        $menuItem->readonly          = $database->readonly ?? 0;
        $menuItem->root              = $database->root ?? 0;
        $menuItem->disabled          = $database->disabled ?? 0;
        $menuItem->link              = null;
        $menuItem->active            = false;
        $menuItem->children          = [];

        if (!empty($resource)) {
            $menuItem->title    = $resource->name ?? $menuItem->title;
            $menuItem->icon     = $resource->icon ?? $menuItem->icon;
            $menuItem->sequence = $resource->sequence ?? $menuItem->sequence;
            $menuItem->public   = $resource->public ?? $menuItem->public;
            $menuItem->readonly = $resource->readonly ?? $menuItem->readonly;
            $menuItem->root     = $resource->root ?? $menuItem->root;
            $menuItem->disabled = $resource->disabled ?? $menuItem->disabled;
        }

        return $menuItem;
    }
}
