<?php

namespace App\Services;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use stdClass;

class MenuService
{
    /**
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $envType
     * @param Admin|null $admin
     * @return array
     * @throws \Exception
     */
    public function getLeftMenu(string|null $envType = null, Admin|null $admin = null): array
    {
        $menu = $this->getResourceMenu($envType, $admin);

        // Verify the ENV type.
        if (empty($envType)) {
            $envType = PermissionService::currentEnvType();
        }

        // Get the name of the current route.
        $currentRouteName = Route::currentRouteName();

        if (isAdmin()) {

            $menu[] = $this->menuItem(
                [ 'title' => 'Admin Dashboard', 'route' => 'admin.dashboard' ],
                $currentRouteName,
                1
            );

            if (isUser()) {
                $menu[] = $this->menuItem(
                    ['title' => 'User Dashboard', 'route' => 'user.dashboard'],
                    $currentRouteName,
                    1
                );
            }

            $menu[] = $this->menuItem(
                [ 'title' => 'My Profile', 'route'    => 'admin.profile.show' ],
                $currentRouteName,
                1
            );

            /*
            $menu[] = $this->menuItem(
                [ 'title'=> 'Change Password', 'route' => 'admin.profile.change-password' ],
                $currentRouteName,
                1
            );
            */

            $menu[] = $this->menuItem(
                [ 'title'=> 'Logout', 'route' => 'admin.logout' ],
                $currentRouteName,
                1
            );

            if (isRootAdmin()) {

                foreach ($menu as $i=>$menuItem) {
                    if (property_exists($menuItem,'tag') && ($menuItem->tag === 'db')) {

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Databases', 'route' => 'admin.system.database.index', 'icon' => 'fa-database' ],
                            $currentRouteName,
                            2
                        );

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Resources', 'route'    => 'admin.system.resource.index', 'icon' => 'fa-table' ],
                            $currentRouteName,
                            2
                        );
                    }
                }

                $menu[] = $this->menuItem(
                    [ 'title'=> 'Settings', 'route' => 'admin.system.settings.show' ],
                    $currentRouteName,
                    1
                );
            }

        } elseif (isUser()) {

            $menu[] = $this->menuItem(
                [ 'title'=> 'My Profile', 'route' => 'user.profile.show' ],
                $currentRouteName,
                1
            );

            $menu[] = $this->menuItem(
                [ 'title'=> 'Logout', 'route' => 'user.logout' ],
                $currentRouteName,
                1
            );

        } else {

            $menu[] = $this->menuItem(
                [ 'name' => 'user-login', 'title'=> 'User Login', 'route' => 'user.login' ],
                $currentRouteName,
                1
            );

            $menu[] = $this->menuItem(
                [ 'name' => 'admin-login', 'title'=> 'Admin Login', 'route' => 'admin.login' ],
                $currentRouteName,
                1
            );

        }

        $menu[] = $this->menuItem(
            [ 'name' => 'contact-login', 'title'=> 'Contact', 'route' => 'system.contact' ],
            $currentRouteName,
            1
        );

        return $menu;
    }

    /**
     * Returns the array of menu items fpr databases.
     *
     * @param string|null $envType
     * @param Admin|null $admin
     * @param string|null $currentRouteName
     * @return array
     * @throws \Exception
     */
    public function getDatabaseMenuItems(
        string|null $envType = null,
        Admin|null $admin = null,
        string|null $currentRouteName): array
    {
        // get the databases
        switch ($envType) {
            case PermissionService::ENV_ADMIN:
                $query = !empty($admin)
                    ? AdminDatabase::where('menu', 1)->where('owner_id', $admin->id)->where('admin', 1)
                    : Database::where('menu', 1)->where('admin', 1);
                break;
            case PermissionService::ENV_USER:
                $query = !empty($admin)
                    ? AdminDatabase::where('menu', 1)->where('owner_id', $admin->id)->where('user', 1)
                    : Database::where('menu', 1)->where('user', 1)->where('public', 1)->where('disabled', 0);
                break;
            case PermissionService::ENV_GUEST:
            default:
                $query = !empty($admin)
                    ? AdminDatabase::where('menu', 1)->where('owner_id', $admin->id)->where('guest', 1)
                    : Database::where('menu', 1)->where('guest', 1)->where('public', 1)->where('disabled', 0);
                break;
        }

        $menu = [];
        ;
        foreach($query->orderBy('sequence', 'ASC')->get() as $database) {

            $database->level    = 1;
            $database->label    = $database->title;
            $database->route    = null;
            $database->url      = null;
            $database->children = [];

            // set route and url
            switch ($envType) {
                case PermissionService::ENV_ADMIN:
                    $database->route = 'admin.' . $database->name . '.index';
                    $database->url = route($database->route);
                    break;
                case PermissionService::ENV_USER:
                    $database->route = 'user.admin.' . $database->name . '.show';
                    $database->url = route($database->route);
                    break;
                case PermissionService::ENV_GUEST:

                    if (Route::has('guest.admin.' . $database->name . '.index')) {
                        $database->route = 'guest.admin.' . $database->name . '.index';
                    } elseif (Route::has('guest.admin.' . $database->name . '.show')) {
                        $database->route = 'guest.admin.' . $database->name . '.show';
                    }

                    if (!empty($database->route)) {
                        try {
                            $database->url = route($database->route, $admin);
                        } catch (\Exception $e) {
                            $database->url = null;
                        }
                    }

                    break;
            }

            $database->active = !empty($currentRouteName) && ($database->route === $currentRouteName) ? 1 : 0;

            $menu[$database->database_id ?? $database->id] = $database;
        }

        return $menu;
    }

    /**
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $envType
     * @param Admin|null $admin
     * @return array
     * @throws \Exception
     */
    public function getTopMenu(string|null $envType = null, Admin|null $admin = null): array
    {
        $menu = $this->getResourceMenu($envType, $admin);

        // Verify the ENV type.
        if (empty($envType)) {
            $envType = PermissionService::currentEnvType();
        }

        // Get the name of the current route.
        $currentRouteName = Route::currentRouteName();

        if (isAdmin()) {

            $admin = Auth::guard('admin')->user();

            // Create user dropdown menu.
            $i = count($menu);
            $menu[$i] = $this->menuItem(
                [ 'name' => 'user-dropdown', 'title' => $admin->username ],
                $currentRouteName
            );
            $menu[$i]->thumbnail = Auth::guard('admin')->user()->thumbnail ?? null;

            $menu[$i]->children[] = $this->menuItem(
                [
                    'title' => 'Admin Dashboard',
                    'route' => 'admin.dashboard',
                    'icon'  => 'fa-dashboard'
                ],
                $currentRouteName
            );

            $menu[$i]->children[] = $this->menuItem(
                [
                    'title' => 'User Dashboard',
                    'route' => 'user.dashboard',
                    'icon'  => 'fa-dashboard'
                ],
                $currentRouteName
            );

            $menu[$i]->children[] = $this->menuItem(
                [
                    'title' => 'My Profile',
                    'route' => 'admin.profile.show',
                    'icon'  => 'fa-user'
                ],
                $currentRouteName
            );

            /*
            $menu[$i]->children[] = $this->menuItem(
                [
                    'title' => 'Change Password',
                    'route' => 'admin.profile.change-password',
                    'icon'  => 'fa-lock'
                ],
                $currentRouteName
            );
            */

            $menu[$i]->children[] = $this->menuItem(
                [
                    'title' => 'Logout',
                    'route' => 'admin.logout',
                    'icon'  => 'fa-sign-out'
                ],
                $currentRouteName
            );

            if (isRootAdmin()) {

                foreach ($menu as $i=>$menuItem) {
                    if (property_exists($menuItem,'tag') && ($menuItem->tag === 'db')) {

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Databases', 'route'    => 'admin.system.database.index', 'icon' => 'fa-database' ],
                            $currentRouteName
                        );

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Resources', 'route'    => 'admin.system.resource.index', 'icon' => 'fa-table' ],
                            $currentRouteName
                        );
                    }
                }
            }

        } elseif (isUser()) {

            $menu[] = $this->menuItem(
                [ 'title'=> 'My Profile', 'route' => 'user.profile.show' ],
                $currentRouteName
            );

            $menu[] = $this->menuItem(
                [ 'title'=> 'Logout', 'route' => 'user.logout' ],
                $currentRouteName
            );

        } else {

            $menu[] = $this->menuItem(
                [ 'title'=> 'User Login', 'route' => 'user.login' ],
                $currentRouteName
            );

            $menu[] = $this->menuItem(
                [ 'title'=> 'Admin Login', 'route' => 'admin.login' ],
                $currentRouteName
            );

        }

        return $menu;
    }

    /**
     * Returns a menu item.
     * *
     * @param array $data
     * @param string $currentRouteName
     * @param int $level
     * @return stdClass
     */
    public function menuItem(
        array $data,
        string $currentRouteName,
        int $level = 1
    ): stdClass
    {
        $menuItem = new stdClass();
        $menuItem->id                = $data['id'] ?? null;
        $menuItem->level             = $level;
        $menuItem->name              = $data['name'] ?? null;
        $menuItem->database          = $data['database'] ?? null;
        $menuItem->table             = $data['table'] ?? null;
        $menuItem->tag               = $data['tag'] ?? null;
        $menuItem->title             = $data['title'] ?? '';
        $menuItem->plural            = $data['plural'] ?? '';
        $menuItem->route             = $data['route'] ?? null;
        $menuItem->url               = Route::has($menuItem->route) ? Route($menuItem->route) : null;
        $menuItem->active            = !empty($menuItem->route) && ($menuItem->route == $currentRouteName);
        $menuItem->guest             = $data['guest'] ?? 0;
        $menuItem->user              = $data['user'] ?? 0;
        $menuItem->admin             = $data['admin'] ?? 0;
        $menuItem->icon              = $data['icon'] ?? null;
        $menuItem->sequence          = $data['sequence'] ?? 0;
        $menuItem->public            = $data['public'] ?? 0;
        $menuItem->readonly          = $data['readonly'] ?? 0;
        $menuItem->root              = $data['root'] ?? 0;
        $menuItem->disabled          = $data['disabled'] ?? 0;
        $menuItem->admin_id          = $data['admin'] ?? null;
        $menuItem->db_id             = $data['db_id'] ?? null;
        $menuItem->db_name           = $data['db_name'] ?? null;
        $menuItem->db_database       = $data['db_database'] ?? null;
        $menuItem->db_tag            = $data['db_tag'] ?? null;
        $menuItem->db_title          = $data['db_title'] ?? null;
        $menuItem->db_plural         = $data['db_plural'] ?? null;
        $menuItem->children          = $data['children'] ?? [];

        return $menuItem;
    }

    /**
     * Returns the array of menu items fpr resources.
     *
     * @param string|null $envType
     * @param Admin|null $admin
     * @param string|null $currentRoute
     * @return array
     * @throws \Exception
     */
    public function getResourceMenu(string|null $envType = null,
                                    Admin|null $admin = null,
                                    string|null $currentRoute = null): array
    {
        // Verify the ENV type.
        if (empty($envType)) {
            $envType = PermissionService::currentEnvType();
        }
        if (!in_array($envType, PermissionService::ENV_TYPES)) {
            throw new \Exception('Invalid current ENV type');
        }

        // Get the name of the current route.
        $currentRouteName = Route::currentRouteName();

        $filters = in_array($envType, [PermissionService::ENV_GUEST, PermissionService::ENV_USER])
            ? [ 'menu' => 1, 'public' => 1, 'disabled' => 0 ]
            : [ 'menu' => 1, 'disabled' => 0 ];

        // get the resources
        if (!empty($admin)) {
            $resources = AdminResource::getResources($admin->id, $envType, null, $filters);
        } else {
            //$resources = Resource::getResources($envType, null, $filters);
            $resources = [];
        }

        // Create the array of menu items.
        $menu = [];

        // get level 1 admin/user/guest-specific items
        if (in_array($envType, [PermissionService::ENV_ADMIN, PermissionService::ENV_GUEST])) {

            // get the database menu items
            $menu = $this->getDatabaseMenuItems($envType, $admin, $currentRoute);

            // add resources by level
            $levelResources = $this->sortResourcesByLevel($resources);

            foreach ($menu as $dbId => $menuItem) {

                // insert level 1 items
                if (array_key_exists(1, $levelResources)) {

                    foreach ($levelResources[1] as $level1Resource) {

                        if ($level1Resource->database_id == $dbId) {

                            $level1Resource= $this->getResourceMenuItem($level1Resource, $envType, $currentRoute, $admin);

                            // insert level 2 items
                            if (array_key_exists(2, $levelResources)) {

                                foreach ($levelResources[2] as $level2Resource) {
                                    if (!empty($level2Resource['parent_id'])) {

                                        if ($level2Resource->parent_id == ($level1Resource->resource_id ?? $level1Resource['id'] ?? null)) {

                                            $level2Resource= $this->getResourceMenuItem($level2Resource, $envType, $currentRoute, $admin);

                                            // insert level 3 items
                                            if (array_key_exists(3, $levelResources)) {

                                                foreach ($levelResources[3] as $level3Resource) {
                                                    if (!empty($level2Resource->parent_id)) {

                                                        if ($level3Resource->parent_id == ($level2Resource->resource_id ?? $level2Resource['id'] ?? null)) {

                                                            $level3Resource= $this->getResourceMenuItem($level3Resource, $envType, $currentRoute, $admin);

                                                            // insert level 4 items
                                                            if (array_key_exists(4, $levelResources)) {

                                                                foreach ($levelResources[4] as $level4Resource) {
                                                                    if (!empty($level3Resource->parent_id)) {

                                                                        if ($level4Resource->parent_id== ($level3Resource->resource_id ?? $level3Resource['id'] ?? null)) {

                                                                            $level4Resource= $this->getResourceMenuItem($level4Resource, $envType, $currentRoute, $admin);

                                                                            $children = $level3Resource->children;
                                                                            $children[] = $level4Resource;
                                                                            $level3Resource->children = $children;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            $children = $level2Resource->children;
                                                            $children[] = $level3Resource;
                                                            $level2Resource->children = $children;
                                                        }
                                                    }
                                                }
                                            }

                                            $children = $level1Resource->children;
                                            $children[] = $level2Resource;
                                            $level1Resource->children = $children;
                                        }
                                    }
                                }
                            }

                            $children = $menu[$dbId]->children;
                            $children[] = $level1Resource;
                            $menu[$dbId]->children = $children;
                        }
                    }
                }
            }
        }

        // should we have a resume link at the top of the menu?
        if ($resumeMenuItem = $this->getResumeMenuItem($envType, $currentRouteName, $admin, 1)) {
            $menu = array_merge([$resumeMenuItem], $menu);
        }

        return array_values($menu);
    }

    /**
     * Returns the array for resources for the specified level from a resource collection.
     *
     * @param array|Collection $resources
     * @param int $level
     * @return array
     */
    public function extractMenuLevelResources(array|Collection $resources, int $level): array
    {
        $levelResources = [];

        for ($i=0; $i<count($resources); $i++) {
            if ($resources[$i]['menu_level'] === $level) {

                // add additional fields
                $resources[$i]->label = $resources[$i]->title;
                $resources[$i]->children = [];

                $levelResources[] = $resources[$i];
            }
        }

        return $levelResources;
    }

    /**
     * Takes a collection or resources and sorts them by level
     *
     * @param array|Collection $resources
     * @return array
     */
    public function sortResourcesByLevel(array|Collection $resources):array
    {
        $levelResources = [];

        for ($level = 1; $level < 5; $level++) {
            $levelResources[$level] = $this->extractMenuLevelResources($resources, $level);
            if (empty($levelResources[$level])) {
                unset($levelResources[$level]);
                break;
            }
        }

        return $levelResources;
    }
    /**
     * Returns a menu item.
     * *
     * @param string $envType
     * @param string|null $currentRouteName
     * @param Admin|null $admin
     * @param int $level
     * @return stdClass|null
     */
    public function getResumeMenuItem(
        string $envType,
        string|null $currentRouteName = null,
        Admin|null $admin = null,
        int $level = 1): stdClass|null
    {
        if (empty($admin)) {
            return null;
        }

        // if there are no jobs for this owner then return null
        if (Resource::withoutGlobalScope(AdminPublicScope::class)
                ->where('name', 'job')->where($envType, 1)->where('public', 1)->count() == 0
        ) {
            return null;
        }

        $menuItem = new stdClass();
        $menuItem->owner_id       = $admin->id;
        $menuItem->id             = null;
        $menuItem->database_id    = null;
        $menuItem->database_name  = null;
        $menuItem->resource_id    = null;
        $menuItem->parent_id      = null;
        $menuItem->name           = 'Resume';
        $menuItem->table          = null;
        $menuItem->tag            = null;
        $menuItem->title          = 'Resume';
        $menuItem->plural         = 'Resumes';
        $menuItem->label          = 'Resume';
        $menuItem->active         = 0; //$resumeRoute == $currentRouteName;
        $menuItem->guest          = $envType == 'guest' ? 1 : 0;
        $menuItem->user           = $envType == 'user' ? 1 : 0;
        $menuItem->admin          = $envType == 'admin' ? 1 : 0;
        $menuItem->global         = $envType == 'admin' ? 1 : 0;
        $menuItem->menu           = 1;
        $menuItem->menu_level     = $level;
        $menuItem->menu_collapsed = 1;
        $menuItem->icon           = null;
        $menuItem->public         = 1;
        $menuItem->readonly       = 0;
        $menuItem->root           = 0;
        $menuItem->disabled       = 0;
        $menuItem->demo           = 0;
        $menuItem->sequence       = 0;
        $menuItem->created_at     = date("Y-m-d H:i:s");
        $menuItem->update_at      = date("Y-m-d H:i:s");
        $menuItem->deleted_at     = 0;
        $menuItem->children       = [];
        $menuItem->route          = 'guest.admin.resume';
        $menuItem->url            = route($menuItem->route, $admin);

        return $menuItem;
    }

    /**
     * Adds the fields to resource needed for a menu item.
     *
     * @param AdminResource $resource
     * @param string $envType
     * @param string|null $currentRouteName
     * @param Admin|null $admin
     * @return AdminResource
     */
    public function getResourceMenuItem(AdminResource $resource,
                                        string        $envType,
                                        string|null   $currentRouteName,
                                        Admin|null    $admin = null): AdminResource
    {
        $resource->label    = $resource->title;
        $resource->route    = resourceRoute($envType,
            $resource->database_name,
            str_replace('_', '-', $resource->name),
            $admin);
        $resource->url      = !empty($resource->route) ? route($resource->route, $admin) : '';
        $resource->children = [];
        $resource->active = !empty($currentRouteName) && ($resource->route === $currentRouteName) ? 1 : 0;

        return $resource;
    }
}
