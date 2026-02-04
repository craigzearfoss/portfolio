<?php

namespace App\Services;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use stdClass;

class MenuService
{
    protected $envType = PermissionService::ENV_GUEST;

    protected $databases = [];
    protected $resources = [];

    protected $hasAdmins = true;
    protected $hasResume = true;
    protected $hasUsers = true;

    protected $isRootAdmin = false;

    protected $admin = null;
    protected $user = null;
    protected $owner = null;

    protected $currentRouteName = null;

    public function __construct(string|null $envType = null,
                                Admin|null  $owner = null,
                                Admin|null  $admin = null,
                                User|null   $user = null,
                                string|null $currentRouteName = null)
    {
        $this->envType          = !empty($envType) ? $envType : PermissionService::currentEnvType();
        $this->owner            = $owner;
        $this->admin            = !empty($admi) ? $admin : loggedInAdmin();
        $this->user             = !empty($user) ? $user : loggedInUser();
        $this->currentRouteName = !empty($currentRouteName) ? $currentRouteName : Route::currentRouteName();
        $this->showAll          = false;

        if (($this->envType == PermissionService::ENV_ADMIN) && !empty(($this->admin) && !empty($this->admin->root))) {
            $this->showAll = true;
            $this->owner = $this->admin;
        }

        $this->isRootAdmin      = ($this->envType == PermissionService::ENV_ADMIN) && !empty($this->admin) && $this->admin->root;

        if (!in_array($this->envType, PermissionService::ENV_TYPES)) {
            throw new \Exception('Invalid current ENV type');
        }

        // get the resources
        $filters = in_array($this->envType, [PermissionService::ENV_GUEST, PermissionService::ENV_USER])
            ? [ 'menu' => 1, 'public' => 1, 'disabled' => 0 ]
            : (!empty($this->admin) && !empty($this->admin->root) ? [] :[ 'menu' => 1, 'disabled' => 0 ]);

        //if (($this->envType == PermissionService::ENV_ADMIN) && !$this->isRootAdmin) {
        //    $filters['root <>'] = 1;
        //}

        if (!empty($owner)) {
            if ($this->owner->root) {
                $this->databases = Database::ownerDatabases(null, $this->envType, $filters);
                $this->resources = Resource::ownerResources(null,null, null, $filters);
            } else {
                $this->databases = AdminDatabase::ownerDatabases($this->owner->id ?? null, $this->envType, $filters);
                $this->resources = AdminResource::ownerResources($this->owner->id, null,null, $filters);
            }
        } else {
            if ($this->showAll) {
                $this->databases = Database::ownerDatabases(null, $this->envType, $filters);
                $this->resources = Resource::ownerResources(null, null, null, $filters);
            } else {
                $this->databases = [];
                $this->resources = [];
            }
        }
    }

    /**
     * Returns the array of items for the left nav menu.
     *
     * @param bool $hasAdmins
     * @param bool $hasUsers
     * @param array $properties
     * @return array
     * @throws \Exception
     */
    public function leftMenu(bool $hasAdmins = true, bool $hasUsers = true, array $properties = []): array
    {
        $this->hasAdmins = boolval($hasAdmins);
        $this->hasUsers = boolval($hasUsers);

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        $menu = $this->getResourceMenu();

        if (($this->hasAdmins) && ($this->isRootAdmin)) {
            $menu[] = $this->menuItem(['title' => 'Settings', 'route' => 'admin.system.settings.show'], 1);
        }

        // add user menu items
        if ($this->hasUsers) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem([ 'title' => 'User Dashboard', 'route' => 'user.dashboard' ], 1);
                $menu[] = $this->menuItem([ 'title'=> 'My User Profile', 'route' => 'user.profile.show' ],  1);
                //$menu[] = $this->menuItem([ 'title'=> 'Change User Password', 'route' => 'admin.profile.change-password' ], 1);
                $menu[] = $this->menuItem([ 'title'=> 'User Logout', 'route' => 'user.logout', 'icon' => 'fa-sign-out' ], 1);
            } else {
                $menu[] = $this->menuItem([ 'name' => 'user-login', 'title'=> 'User Login', 'route' => 'user.login', 'icon' => 'fa-sign-in' ], 1);
            }
        }

        // add admin menu items
        if ($this->hasAdmins) {

            if ($this->isRootAdmin) {
                $menu[] = $this->menuItem(['title' => 'Settings', 'route' => 'admin.system.settings.show'], 1);
            }

            if (!empty($this->admin)) {
                $menu[] = $this->menuItem(['title' => 'Admin Dashboard', 'route' => 'admin.dashboard'], 1);
                $menu[] = $this->menuItem(['title' => 'My Admin Profile', 'route' => 'admin.profile.show'], 1);
                //$menu[] = $this->menuItem([ 'title'=> 'Change Admin Password', 'route' => 'admin.profile.change-password' ], 1);
                $menu[] = $this->menuItem(['title' => 'Admin Logout', 'route' => 'admin.logout', 'icon' => 'fa-sign-out'], 1);

                if ($this->isRootAdmin) {
                    foreach ($menu as $i => $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $menu[$i]->children[] = $this->menuItem(['title' => 'Databases', 'route' => 'admin.system.database.index', 'icon' => 'fa-database'], 2);
                            $menu[$i]->children[] = $this->menuItem(['title' => 'Resources', 'route' => 'admin.system.resource.index', 'icon' => 'fa-table'], 2);
                        }
                    }
                }
            } else {
                $menu[] = $this->menuItem([ 'name' => 'admin-login', 'title'=> 'Admin Login', 'route' => 'admin.login', 'icon' => 'fa-sign-in' ], 1);
            }
        }

        return $menu;
    }

    /**
     * Returns the array of items for the left nav menu.
     *
     * @param bool $hasAdmins
     * @param bool $hasUsers
     * @param array $properties
     * @return array
     * @throws \Exception
     */
    public function topMenu(bool $hasAdmins = true, bool $hasUsers = true, array $properties = []): array
    {
        $this->hasAdmins = boolval($hasAdmins);
        $this->hasUsers = boolval($hasUsers);

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        $menu = $this->getResourceMenu();

        if ($this->hasUsers && empty($this->admin)) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem(['title' => 'User Dashboard', 'route' => 'user.dashboard', 'icon' => 'fa-dashboard']);
                $menu[] = $this->menuItem([ 'title'=> 'My Profile', 'route' => 'user.profile.show' ]);
            } else {
                $menu[] = $this->menuItem(['name' => 'user-login', 'title' => 'User Login', 'route' => 'user.login', 'icon' => 'fa-sign-in'], 1);
            }
        }

        // add admin menu items
        if ($this->hasAdmins) {

            if (!empty($this->admin)) {

                $i = count($menu);
                $adminDropdownMenu = $this->menuItem([
                    'name' => 'user-dropdown',
                    'title' => $this->admin->username ?? '',
                ]);
                $adminDropdownMenu->thumbnail  = $this->admin->thumbnail ?? null;

                $adminDropdownMenu->children[] = $this->menuItem(['title' => 'Admin Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fa-dashboard']);
                $adminDropdownMenu->children[] = $this->menuItem(['title' => 'My Admin Profile', 'route' => 'admin.profile.show', 'icon' => 'fa-user']);
                $adminDropdownMenu->children[] = $this->menuItem([ 'title' => 'Change Password', 'route' => 'admin.profile.change-password', 'icon'  => 'fa-lock' ]);

                if (!empty($this->user)) {
                    $adminDropdownMenu->children[] = $this->menuItem(['title' => 'User Dashboard', 'route' => 'user.dashboard', 'icon' => 'fa-dashboard']);
                    $menu[] = $this->menuItem([ 'title'=> 'My Profile', 'route' => 'user.profile.show' ]);
                } else {
                    $adminDropdownMenu->children[] = $this->menuItem(['title' => 'User Login', 'route' => 'user.login', 'icon' => 'fa-sign-in']);
                }

                $adminDropdownMenu->children[] = $this->menuItem(['title' => 'Admin Logout', 'route' => 'admin.logout', 'icon' => 'fa-sign-out']);
                if (!empty($this->user)) {
                    $adminDropdownMenu->children[] = $this->menuItem(['title' => 'User Logout', 'route' => 'user.logout', 'icon' => 'fa-sign-out']);
                }

                if ($this->isRootAdmin) {

                    foreach ($menu as $i => $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $adminDropdownMenu->children[] = $this->menuItem(['title' => 'Databases', 'route' => 'admin.system.database.index', 'icon' => 'fa-database']);
                            $adminDropdownMenu->children[] = $this->menuItem(['title' => 'Resources', 'route' => 'admin.system.resource.index', 'icon' => 'fa-table']);
                        }
                    }
                }

                $menu[] = $adminDropdownMenu;

            } else {
                $menu[] = $this->menuItem([ 'name' => 'admin-login', 'title'=> 'Admin Login', 'route' => 'admin.login', 'icon' => 'fa-sign-in' ], 1);
            }
        }

        return $menu;
    }

    /**
     * Returns the array of menu items fpr databases.
     *
     * @return array
     * @throws \Exception
     */
    public function getDatabaseMenuItems(): array
    {
        $menu = [];

        foreach($this->databases as $database) {

            if ($this->includeItem($database)) {

                $route = $this->envType . '.' . $database->name . '.index';

                if (Route::has($route)) {
                    if ($this->envType == PermissionService::ENV_ADMIN) {
                        $url = ((!empty($this->admin) && !empty($this->admin->root))
                                && !$this->showAll
                               )
                            ? route($route, [ 'owner_id' => $this->owner->id ])
                            : route($route);
                    } else {
                        $url = (!empty($this->owner) && !in_array($database->name, ['dictionary']))
                            ? route($route, $this->owner)
                            : route($route);
                    }
                } else {
                    $url = 'DATABASE ROUTE: ' . $route;
                }

                $database->level    = 1;
                $database->label    = $database->title;
                $database->route    = $route;
                $database->url      = $url;
                $database->children = [];
                $database->active   = !empty($this->currentRouteName) && ($database->route === $this->currentRouteName) ? 1 : 0;
                $menu[$database->database_id ?? $database->id] = $database;
                }
        }

        return $menu;
    }

    /**
     * Returns a menu item.
     * *
     * @param array $data
     * @param int $level
     * @return stdClass
     */
    public function menuItem(array $data, int $level = 1): stdClass
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
        $menuItem->route             = $data['route'] ?? '';
        $menuItem->url               = !empty($menuItem->route) && Route::has($menuItem->route)
                                            ? Route($menuItem->route)
                                            : null;
        $menuItem->active            = !empty($menuItem->route) && ($menuItem->route == $this->currentRouteName);
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
     * @return array
     * @throws \Exception
     */
    public function getResourceMenu(): array
    {
        // Create the array of menu items.
        $menu = [];

        // get level 1 admin/user/guest-specific items
        if (in_array($this->envType, [PermissionService::ENV_ADMIN, PermissionService::ENV_GUEST])) {

            // get the database menu items
            $menu = $this->getDatabaseMenuItems();

            // add resources by level
            $levelResources = $this->sortResourcesByLevel();

            foreach ($menu as $dbId => $menuItem) {

                if ($this->includeItem($menuItem)) {

                    // insert level 1 items
                    if (array_key_exists(1, $levelResources)) {

                        foreach ($levelResources[1] as $level1Resource) {

                            if ($level1Resource->database_id == $dbId) {

                                $level1Resource = $this->getResourceMenuItem($level1Resource);

                                // insert level 2 items
                                if (array_key_exists(2, $levelResources)) {

                                    foreach ($levelResources[2] as $level2Resource) {
                                        if (!empty($level2Resource['parent_id'])) {

                                            if ($level2Resource->parent_id == ($level1Resource->resource_id ?? $level1Resource['id'] ?? null)) {

                                                $level2Resource = $this->getResourceMenuItem($level2Resource);

                                                // insert level 3 items
                                                if (array_key_exists(3, $levelResources)) {

                                                    foreach ($levelResources[3] as $level3Resource) {
                                                        if (!empty($level2Resource->parent_id)) {

                                                            if ($level3Resource->parent_id == ($level2Resource->resource_id ?? $level2Resource['id'] ?? null)) {

                                                                $level3Resource = $this->getResourceMenuItem($level3Resource);

                                                                // insert level 4 items
                                                                if (array_key_exists(4, $levelResources)) {

                                                                    foreach ($levelResources[4] as $level4Resource) {
                                                                        if (!empty($level3Resource->parent_id)) {

                                                                            if ($level4Resource->parent_id == ($level3Resource->resource_id ?? $level3Resource['id'] ?? null)) {

                                                                                $level4Resource = $this->getResourceMenuItem($level4Resource);

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
        }

        // should we have a resume link at the top of the menu?
        if ($this->hasResume) {
            if ($resumeMenuItem = $this->getResumeMenuItem(1)) {
                $menu = array_merge([$resumeMenuItem], $menu);
            }
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
     * @return array
     */
    public function sortResourcesByLevel():array
    {
        $levelResources = [];

        for ($level = 1; $level < 5; $level++) {
            $levelResources[$level] = $this->extractMenuLevelResources($this->resources, $level);
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
     * @param int $level
     * @return stdClass|null
     */
    public function getResumeMenuItem(int $level = 1): stdClass|null
    {
        if (empty($this->owner)) {
            return null;
        }

        // if there are no jobs for this owner then return null
        if (Resource::withoutGlobalScope(AdminPublicScope::class)
                ->where('name', 'job')->where($this->envType, 1)->where('public', 1)->count() == 0
        ) {
            return null;
        }

        // get route and url
        if ($this->envType == PermissionService::ENV_ADMIN) {
            $routeName = 'admin.career.resume.preview';
            $url = !empty($this->owner) ? route($routeName, $this->owner) : '';
        } else {
            $routeName = 'guest.resume';
            $url = !empty($this->owner) ? route($routeName, $this->owner) : '';
        }

        $menuItem = new stdClass();
        $menuItem->owner_id       = $this->owner->id;
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
        $menuItem->active         = $routeName == $this->currentRouteName;
        $menuItem->guest          = $this->envType == 'guest' ? 1 : 0;
        $menuItem->user           = $this->envType == 'user' ? 1 : 0;
        $menuItem->admin          = $this->envType == 'admin' ? 1 : 0;
        $menuItem->global         = $this->envType == 'global' ? 1 : 0;
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
        $menuItem->route          = $routeName;
        $menuItem->url            = $url;

        return $menuItem;
    }

    /**
     * Adds the fields to resource needed for a menu item.
     *
     * @param Resource|AdminResource $resource
     * @return Resource|AdminResource
     */
    public function getResourceMenuItem(Resource|AdminResource $resource): Resource|AdminResource
    {
        $route = $this->envType . '.' . $resource->database_name . '.' . $resource->name . '.index';

        if (Route::has($route)) {
            if ($this->envType == PermissionService::ENV_ADMIN) {
                $url = ($resource->has_owner
                        && !in_array($resource->database_name, ['dictionary'])
                        && (!empty($this->admin) && !empty($this->admin->root))
                        && !empty($this->showAll)
                       )
                    ? route($route, [ 'owner_id' => $this->owner->id ])
                    : route($route);
            } else {
                $url = ($resource->has_owner && !empty($this->owner) )
                    ? route($route, $this->owner)
                    : route($route);
            }
        } else {
            $url = 'RESOURCE ROUTE: ' . $route;
        }

        $resource->label    = $resource->title;
        $resource->route    = $route;
        $resource->url      = $url;
        $resource->children = [];
        $resource->active = !empty($this->currentRouteName) && ($resource->route === $this->currentRouteName) ? 1 : 0;

        return $resource;
    }

    /**
     * Returns true if the specified item should be included in the menu.
     *
     * @param $menuItem
     * @return bool
     */
    private function includeItem($menuItem): bool
    {
        if (empty($menuItem->menu)) {
            return false;

        }
        switch ($this->envType) {
            case PermissionService::ENV_ADMIN:
                if (empty($this->admin)) {
                    return false;
                } elseif(!empty($this->admin->root)) {
                    // root admins can see every menu item
                    return true;
                } elseif (empty($menuItem->admin) || empty($menuItem->global)) {
                    return false;
                }
                break;
            case PermissionService::ENV_USER:
                if (empty($this->user) || empty($menuItem->user) || empty($menuItem->global)) {
                    return false;
                }
                break;
            case PermissionService::ENV_GUEST:
                if (empty($menuItem->guest) || empty($menuItem->global)) {
                    return false;
                }
                break;
        }

        return true;
    }
}
