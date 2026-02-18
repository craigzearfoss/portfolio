<?php

namespace App\Services;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Owner;
use App\Models\System\Resource;
use App\Models\System\User;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use stdClass;

/**
 *
 */
class MenuService
{
    /**
     * @var EnvTypes|null
     */
    protected EnvTypes|null $envType = null;

    /**
     * @var array|Collection
     */
    protected array|Collection $databases = [];

    /**
     * @var array|Collection
     */
    protected array|Collection $resources = [];

    /**
     * @var bool
     */
    protected bool $hasAdmins = true;

    /**
     * @var bool
     */
    protected bool $hasResume = true;

    /**
     * @var bool
     */
    protected bool $hasUsers = true;

    /**
     * @var bool
     */
    protected bool $isRootAdmin = false;

    /**
     * @var Admin|Owner|null
     */
    protected Admin|Owner|null $admin = null;

    /**
     * @var User|null
     */
    protected User|null $user = null;

    /**
     * @var Admin|Owner|null
     */
    protected Admin|Owner|null $owner = null;

    /**
     * @var bool|Repository|Application|mixed|object|null
     */
    protected bool $adminsEnabled = true;

    /**
     * @var bool|Repository|Application|mixed|object|null
     */
    protected bool $usersEnabled = true;

    /**
     * @var array|string[]
     */
    protected array $globalDatabases = [
        'dictionary',
    ];

    /**
     * @var bool
     */
    protected bool $showAll = false;

    /**
     * @var string|null
     */
    protected string|null $currentRouteName = null;

    /**
     * @var array
     */
    protected array $childResources = [
        'personal.recipes' => [
            'personal.recipe_ingredients',
            'personal.recipe_steps',
        ],
        'portfolio.jobs' => [
            'portfolio.job_coworkers',
            'portfolio.job_skills',
            'portfolio.job_tasks',
        ]
    ];

    /**
     * @param EnvTypes|null $envType
     * @param Admin|null $owner
     * @param Admin|null $admin
     * @param User|null $user
     * @param string|null $currentRouteName
     * @throws Exception
     */
    public function __construct(EnvTypes|null $envType = null,
                                Admin|null    $owner = null,
                                Admin|null    $admin = null,
                                User|null     $user = null,
                                string|null   $currentRouteName = null)
    {
        $this->envType          = $envType ?? getEnvType();
        $this->owner            = $owner;
        $this->admin            = !empty($admi) ? $admin : loggedInAdmin();
        $this->user             = !empty($user) ? $user : loggedInUser();
        $this->currentRouteName = !empty($currentRouteName) ? $currentRouteName : Route::currentRouteName();
        $this->showAll          = false;
//dd([$this->envType->value, $this->owner, $this->admin, $this->user, $this->currentRouteName, $this->showAll]);

        // in the admin area root admins get to see all menu items
        if (($this->envType == EnvTypes::ADMIN) && !empty($this->admin->root)) {
            $this->isRootAdmin = true;
            $this->showAll = true;
            $this->owner = null;
        }

        $this->adminsEnabled    = config('app.admins_enabled');
        $this->usersEnabled     = config('app.users_enabled');

        if (!in_array($this->envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new Exception('Invalid current ENV type');
        }

        // set the filters for the databases and resources
        // note that root admins have all resource types added to the menu
        if ($this->envType == EnvTypes::ADMIN) {
            $filters = $this->showAll
                ? []
                : [
                    'menu'                => 1,
                    $this->envType->value => true,
                    'disabled'            => false
                  ];
        } else {
            $filters = [
                'menu'                => 1,
                $this->envType->value => true,
                'public'              => true,
                'disabled'            => false
            ];
        }

        // get the databases and resources
        if ($this->isRootAdmin) {

            // note that for root admins we pull menu items from the admins and resources
            // tables instead of the admin_databases and admin_resources tables
            $this->databases = new Database()->ownerDatabases(null, $this->envType, $filters);
            $this->resources = new Resource()->ownerResources(null, $this->envType, null, $filters);

        } else {

            $this->databases = new AdminDatabase()->ownerDatabases($this->owner->id ?? null, $this->envType, $filters);
            $this->resources = new AdminResource()->ownerResources($this->owner->id ?? null, $this->envType, null, $filters);
        }
    }

    /**
     * Returns the array of items for the left nav menu.
     *
     * @param bool $hasAdmins
     * @param bool $hasUsers
     * @param array $properties
     * @return array
     * @throws Exception
     */
    public function leftMenu(bool $hasAdmins = true, bool $hasUsers = true, array $properties = []): array
    {
        $this->hasAdmins = $hasAdmins;
        $this->hasUsers = $hasUsers;

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        $menu = $this->getResourceMenu();

        if (($this->hasAdmins) && ($this->isRootAdmin)) {
            $menu[] = $this->menuItem([ 'title'=>'Settings', 'route'=>'admin.system.settings.show' ]);
        }

        // add user menu items
        if ($this->hasUsers && config('app.users_enabled')) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem([ 'title'=>'User Dashboard',       'route'=>'user.dashboard' ]);
                $menu[] = $this->menuItem([ 'title'=>'My User Profile',      'route'=>'user.profile.show' ]);
                //$menu[] = $this->menuItem([ 'title'=>'Change User Password', 'route'=>'admin.profile.change-password' ]);
                $menu[] = $this->menuItem([ 'title'=>'User Logout',          'route'=>'user.logout', 'icon' => 'fa-sign-out' ]);
            } else {
                $menu[] = $this->menuItem([ 'title'=>'User Login',           'route' => 'user.login', 'icon'=>'fa-sign-in', 'name'=>'user-login' ]);
            }
        }

        // add admin menu items
        if ($this->hasAdmins) {

            if (!empty($this->admin)) {
                $menu[] = $this->menuItem([ 'title'=>'Admin Dashboard',  'route'=>'admin.dashboard' ]);
                $menu[] = $this->menuItem([ 'title'=>'My Admin Profile', 'route'=>'admin.profile.show' ]);
                //$menu[] = $this->menuItem([ 'title'=>'Change Password',  'route'=>'admin.profile.change-password' ]);
                $menu[] = $this->menuItem([ 'title'=>'Admin Logout',     'route'=>'admin.logout', 'icon'=>'fa-sign-out' ]);

                if ($this->isRootAdmin) {
                    foreach ($menu as $i => $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $menuItem[$i]->children[] = $this->menuItem([ 'title'=>'Databases', 'route'=>'admin.system.database.index', 'icon'=>'fa-database' ], 2);
                            $menuItem[$i]->children[] = $this->menuItem([ 'title'=>'Resources', 'route'=>'admin.system.resource.index', 'icon'=>'fa-table' ], 2);
                        }
                    }
                }
            } else {
                $menu[] = $this->menuItem( [ 'name'=>'admin-login', 'title'=>'Admin Login', 'route'=>'admin.login', 'icon'=>'fa-sign-in' ]);
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
     * @throws Exception
     */
    public function topMenu(bool $hasAdmins = true, bool $hasUsers = true, array $properties = []): array
    {
        $this->hasAdmins = $hasAdmins;
        $this->hasUsers = $hasUsers;

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }

        $menu = $this->getResourceMenu();

        if ($this->envType == EnvTypes::GUEST) {
            $menu[] = $this->menuItem(['title'=>'Candidates', 'route' => 'guest.admin.index', 'icon' => 'fa-dashboard' ]);
        }

        if ($this->hasUsers && empty($this->admin)) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem([ 'title'=>'User Dashboard',  'route'=>'user.dashboard', 'icon' => 'fa-dashboard' ]);
                $menu[] = $this->menuItem([ 'title'=>'My Profile',      'route'=>'user.profile.show' ]);
            } else {
                if (config('app.users_enabled')) {
                    $menu[] = $this->menuItem(['title' => 'User Login', 'route' => 'user.login', 'icon' => 'fa-sign-in', 'name' => 'user-login']);
                }
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

                $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'Admin Dashboard',  'route'=>'admin.dashboard',               'icon'=>'fa-dashboard' ]);
                $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'My Admin Profile', 'route'=>'admin.profile.show',            'icon'=>'fa-user' ]);
                //$adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'Change Password',  'route'=>'admin.profile.change-password', 'icon' =>'fa-lock' ]);

                if (config('app.users_enabled')) {
                    if (!empty($this->user)) {
                        $adminDropdownMenu->children[] = $this->menuItem(['title' => 'User Dashboard', 'route' => 'user.dashboard', 'icon' => 'fa-dashboard']);
                        $menu[] = $this->menuItem(['title' => 'My Profile', 'route' => 'user.profile.show']);
                    } else {
                        $adminDropdownMenu->children[] = $this->menuItem(['title' => 'User Login', 'route' => 'user.login', 'icon' => 'fa-sign-in']);
                    }
                }

                $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'Admin Logout', 'route'=>'admin.logout', 'icon'=>'fa-sign-out' ]);
                if (!empty($this->user) && config('app.users_enabled')) {
                    $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'User Logout', 'route'=>'user.logout', 'icon'=>'fa-sign-out' ]);
                }

                if ($this->isRootAdmin) {

                    foreach ($menu as $i => $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'Databases', 'route'=>'admin.system.database.index', 'icon' => 'fa-database' ]);
                            $adminDropdownMenu->children[] = $this->menuItem([ 'title'=>'Resources', 'route'=>'admin.system.resource.index', 'icon' => 'fa-table' ]);
                        }
                    }
                }

                $menu[] = $adminDropdownMenu;

            } else {
                $menu[] = $this->menuItem([ 'title'=>'Admin Login', 'route'=>'admin.login', 'icon'=>'fa-sign-in', 'name'=>'admin-login' ]);
            }
        }

        return $menu;
    }

    /**
     * Returns the array of menu items fpr databases.
     *
     * @return array
     * @throws Exception
     */
    public function getDatabaseMenuItems(): array
    {
        $menu = [];

        foreach($this->databases as $database) {

            if ($this->includeItem($database)) {

                $route = $this->envType->value . '.' . $database->name . '.index';

                if (Route::has($route)) {
                    if ($this->envType == EnvTypes::ADMIN) {
                        $url = (!empty($this->admin->root) && !$this->showAll)
                            ? route($route, [ 'owner_id' => $this->owner->id ])
                            : route($route);
                    } else {
                        try {
                            $url = (!empty($this->owner) && ($database->name != 'dictionary'))
                                ? route($route, $this->owner)
                                : route($route);
                        } catch (\Exception $e) {
                            $url = null;
                        }
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
                $menu[$database->name ?? $database->id] = $database;
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
     * Returns the parent resource or null.
     *
     * @param string $resource
     * @return string|null
     */
    public function getParentResource(string $resource): string|null
    {
        foreach ($this->childResources as $parentResource=>$childResources) {
            if (in_array($resource, $childResources)) {
                return $parentResource;
            }
        }

        return null;
    }

    /**
     * Returns the child resources or null.
     *
     * @param string $resource
     * @return string|null
     */
    public function getChildResources(string $resource): string|null
    {
        if (array_key_exists($resource, $this->childResources)) {
            return $this->childResources[$resource];
        } else {
            return null;
        }
    }

    /**
     * Returns the array of menu items fpr resources.
     *
     * @return array
     * @throws Exception
     */
    public function getResourceMenu(): array
    {
        // Create the array of menu items.
        $menu = [];

        if (in_array($this->currentRouteName, [ 'guest.index', 'guest.admin.index' ])) {
            // on home page and dashboard do not display resource menu item
            return $menu;
        }

        // get level 1 admin/user/guest-specific items
        if (in_array($this->envType, [EnvTypes::ADMIN, EnvTypes::GUEST])) {

            // get the database menu items
            $menu = $this->getDatabaseMenuItems();

            // add resources by level
            $levelResources = $this->sortResourcesByLevel();

            for ($level=4; $level>1; $level--) {

                if (array_key_exists($level, $levelResources)) {

                    foreach ($levelResources[$level] as $resourceTable=>$resource) {

                        if ($this->includeItem($resource)) {

                            if ($parentResource = $this->getParentResource($resource->database_name . '.' . $resource->table)) {

                                if (array_key_exists($parentResource, $levelResources[$level - 1])) {
                                    $children = array_merge($levelResources[$level - 1][$parentResource]->children, [ $resource ]);
                                    $levelResources[$level - 1][$parentResource]->children = $children;
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($levelResources[1])) {
                foreach ($levelResources[1] as $resourceTable => $resource) {
                    if (array_key_exists($resource->database_name, $menu)) {
                        $children = array_merge($menu[$resource->database_name]->children, [$resource]);
                        $menu[$resource->database_name]->children = $children;
                    }
                }
            }

            return array_values($menu);
        }

        // should we have a resume link at the top of the menu?
        if (!$this->isRootAdmin && $this->hasResume) {
            if ($resumeMenuItem = $this->getResumeMenuItem()) {
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

        for ($i=1; $i<count($resources); $i++) {
            if ($resources[$i]['menu_level'] === $level) {

                // add additional fields
                $resources[$i]->label = $resources[$i]->title;
                $resources[$i]->children = [];

                $levelResources[$resources[$i]->database_name . '.' . $resources[$i]->table] = $resources[$i];
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
        if (new Resource()->withoutGlobalScope(AdminPublicScope::class)
                ->where('name', 'job')->where($this->envType->value, 1)->where('public', 1)->count() == 0
        ) {
            return null;
        }

        // get route and url
        $routeName = ($this->envType == EnvTypes::ADMIN)
            ? 'admin.career.resume.preview'
            : 'guest.resume';
        $url = route($routeName, $this->owner);

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
        //????????????????
        $menuItem->guest          = $this->envType == EnvTypes::GUEST ? 1 : 0;
        $menuItem->user           = $this->envType == EnvTypes::USER ? 1 : 0;
        $menuItem->admin          = $this->envType == EnvTypes::ADMIN ? 1 : 0;
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
        $routeName = $this->envType->value . '.' . $resource['database_name'] . '.' . $resource['name'] . '.index';

        if (Route::has($routeName)) {

            if ($this->envType == EnvTypes::ADMIN) {
                $url = route($routeName);
            } else{
                $url = ($resource['has_owner'] && !empty($this->owner) )
                    ? route($routeName, $this->owner)
                    : route($routeName);
            }
/*
                $url = ($resource->has_owner
                && (!empty($this->admin) && !empty($this->admin->root))
                && !$this->showAll
            )
                ? route($route, array_merge([$resource], !empty($this->owner) ? [ 'owner_id' => $this->owner->id ] : []))
                : route($route);

            if ($this->envType == EnvTypes::ADMIN) {
                $url = ($resource->has_owner
                        && (!empty($this->admin) && !empty($this->admin->root))
                        && !$this->showAll
                       )
                    ? route($route, [ 'owner_id' => $this->owner->id ])
                    : route($route);
            } else {
                $url = ($resource->has_owner && !empty($this->owner) )
                    ? route($route, $this->owner)
                    : route($route);
            }
            */
        } else {
            $url = 'RESOURCE ROUTE: ' . $routeName;
        }

        $resource->label    = $resource->title;
        $resource->route    = $routeName;
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

            case EnvTypes::ADMIN:
                if (empty($this->admin)) {
                    return false;
                } elseif(!empty($this->admin->root)) {
                    // root admins can see every menu item
                    return true;
                } elseif (empty($menuItem->admin) && empty($menuItem->global)) {
                    return false;
                }
                break;

            case EnvTypes::USER:
                if (empty($this->user) || empty($menuItem->user) || empty($menuItem->global)) {
                    return false;
                }
                break;

            case EnvTypes::GUEST:
                if (in_array(get_class($menuItem), ['App\Models\System\AdminDatabase', 'App\Models\System\Database'])
                    && ($menuItem->name == 'system')
                ) {
                    return false;
                }
                if (empty($menuItem->guest) || empty($menuItem->global)) {
                    return false;
                }
                break;
        }

        return true;
    }

    /**
     * Returns true if the specified resource should be included in the menu.
     *
     * @param $resource
     * @return bool
     */
    private function includeResource($resource): bool
    {
        return true;
    }
}
