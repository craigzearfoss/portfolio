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
use JetBrains\PhpStorm\NoReturn;
use stdClass;

/**
 *
 */
class MenuService
{
    /**
     * @var bool
     */
    protected bool $singleAdminMode = false;

    /**
     * @var EnvTypes|null
     */
    protected EnvTypes|null $envType = null;

    /**
     * @var array|Collection
     */
    protected array $resourcesByDatabase = [];

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
     * @var int
     */
    protected int $publicAdminCount = 0;

    /**
     * @var bool|Repository|Application|mixed|object|null
     */
    protected bool $adminsEnabled = true;

    /**
     * @var bool|Repository|Application|mixed|object|null
     */
    protected bool $usersEnabled = true;

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
        $this->singleAdminMode  = config('app.single_admin_mode');
        $this->envType          = $envType ?? getEnvType();
        $this->owner            = $owner;
        $this->admin            = !empty($admin) ? $admin : loggedInAdmin();
        $this->user             = !empty($user) ? $user : loggedInUser();
        $this->currentRouteName = !empty($currentRouteName) ? $currentRouteName : Route::currentRouteName();
        $this->showAll          = false;

        // in the admin area root admins get to see all menu items
        if (($this->envType == EnvTypes::ADMIN) && !empty($this->admin->is_root)) {
            $this->isRootAdmin = true;
            $this->showAll = true;
            $this->owner = null;
        }

        $this->adminsEnabled    = config('app.admins_enabled');
        $this->usersEnabled     = config('app.users_enabled');

        $this->publicAdminCount = new Admin()->where('is_public', '=', true)
            ->where('is_disabled', '=', false)->count();

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
                    'is_disabled'         => false
                  ];
        } else {
            $filters = [
                'menu'                => 1,
                'is_public'           => true,
                'is_disabled'         => false
            ];
        }

        // get the databases and resources
        if ($this->isRootAdmin) {
            // note that for root admins we pull menu items from the admins and resources
            // tables instead of the admin_databases and admin_resources tables
            $this->resourcesByDatabase = new Resource()->ownerResourcesByDatabase($this->envType, null, $filters);
        } else {
            $this->resourcesByDatabase = new AdminResource()->ownerResourcesByDatabase($this->owner ?? null, $this->envType, null, $filters);
        }

        if (request()->has('debug-menu')) {
            $this->ddDebug();
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
            $menu[] = $this->menuItem([
                'tag'   => 'settings',
                'title' => 'Settings',
                'route' => 'admin.system.settings.show',
            ]);
        }

        // add user menu items
        if ($this->hasUsers && config('app.users_enabled')) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem([
                    'tag'   => 'user_dashboard',
                    'title' => 'User Dashboard',
                    'route' => 'user.dashboard',
                ]);
                $menu[] = $this->menuItem([
                    'tag'   => 'my_user_profile',
                    'title' => 'My User Profile',
                    'route' => 'user.profile.show',
                ]);
//                $menu[] = $this->menuItem([
//                    'tag'   => 'change_user_password',
//                    'title' => 'Change User Password',
//                    'route' => 'admin.profile.change-password'
//                ]);
                $menu[] = $this->menuItem([
                    'tag'   => 'user_logout',
                    'title' => 'User Logout',
                    'route' => 'user.logout',
                    'icon'  => 'fa-sign-out',
                ]);
            } else {
                $menu[] = $this->menuItem([
                    'tag'   => 'user_login',
                    'title' => 'User Login',
                    'route' => 'user.login',
                    'icon'  => 'fa-sign-in',
                    'name'  => 'user-login'
                ]);
            }
        }

        // add admin menu items
        if ($this->hasAdmins) {

            if (!empty($this->admin)) {
                $menu[] = $this->menuItem([
                    'tag'   => 'admin_dashboard',
                    'title' => 'Admin Dashboard',
                    'route' => 'admin.dashboard'
                ]);
                $menu[] = $this->menuItem([
                    'tag'   => 'my_admin_profile',
                    'title' => 'My Admin Profile',
                    'route' => 'admin.profile.show'
                ]);
//                $menu[] = $this->menuItem([
//                    'tag'   => 'change_password',
//                    'title' => 'Change Password',
//                    'route' => 'admin.profile.change-password'
//                ]);
                $menu[] = $this->menuItem([
                    'tag'   => 'admin_logout',
                    'title' => 'Admin Logout',
                    'route' => 'admin.logout',
                    'icon'  => 'fa-sign-out'
                ]);

                if ($this->isRootAdmin) {
                    foreach ($menu as $i => $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $menuItem[$i]->children[] = $this->menuItem([
                                'tag'   => 'databases',
                                'title' => 'Databases',
                                'route' => 'admin.system.database.index',
                                'icon'  => 'fa-database'
                            ], 2);
                            $menuItem[$i]->children[] = $this->menuItem([
                                'tag'   => 'resources',
                                'title' => 'Resources',
                                'route' => 'admin.system.resource.index',
                                'icon'  =>'fa-table' ], 2);
                        }
                    }
                }
            } else {
                if (!$this->singleAdminMode) {
                    $menu[] = $this->menuItem([
                        'tag' => 'admin_login',
                        'name' => 'admin-login',
                        'title' => 'Admin Login',
                        'route' => 'admin.login',
                        'icon' => 'fa-sign-in'
                    ]);
                }
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

        if (($this->envType == EnvTypes::GUEST) && !$this->singleAdminMode) {
            /// only show candidates menu option if there are more than one public, non-disabled admins
            $menu[] = $this->menuItem([
                'tag'   => 'candidates',
                'title' => 'Candidates',
                'route' => 'guest.admin.index',
                'icon'  => 'fa-dashboard'
            ]);
        }

        if ($this->hasUsers && empty($this->admin)) {
            if (!empty($this->user)) {
                $menu[] = $this->menuItem([
                    'tag'   => 'user_dashboard',
                    'title' =>'User Dashboard',
                    'route' =>'user.dashboard',
                    'icon'  => 'fa-dashboard',
                ]);
                $menu[] = $this->menuItem([
                    'tag'   => 'my_profile',
                    'title' =>'My Profile',
                    'route' =>'user.profile.show',
                ]);
            } else {
                if (config('app.users_enabled')) {
                    $menu[] = $this->menuItem([
                        'tag'   => 'user_login',
                        'title' => 'User Login',
                        'route' => 'user.login',
                        'icon'  => 'fa-sign-in',
                        'name'  => 'user-login',
                    ]);
                }
            }
        }

        // add admin menu items
        if ($this->hasAdmins) {

            if (!empty($this->admin)) {

                $adminDropdownMenu = $this->menuItem([
                    'tag'   => 'admin_username',
                    'name'  => 'user-dropdown',
                    'title' => $this->admin->username ?? '',
                ]);
                $adminDropdownMenu->thumbnail  = $this->admin->thumbnail ?? null;

                $adminDropdownMenu->children[] = $this->menuItem([
                    'tag'   => 'admin_dashboard',
                    'title' => 'Admin Dashboard',
                    'route' => 'admin.dashboard',
                    'icon'  => 'fa-dashboard',
                ]);
                $adminDropdownMenu->children[] = $this->menuItem([
                    'tag'   => 'my_admin_profile',
                    'title' => 'My Admin Profile',
                    'route' => 'admin.profile.show',
                    'icon'  => 'fa-user',
                ]);
//                $adminDropdownMenu->children[] = $this->menuItem([
//                    'tag'   => 'change_password',
//                    'title' => 'Change Password',
//                    'route' => 'admin.profile.change-password',
//                    'icon'  =>'fa-lock',
//                ]);

                if (config('app.users_enabled')) {
                    if (!empty($this->user)) {
                        $adminDropdownMenu->children[] = $this->menuItem([
                            'tag'   => 'user_dashboard',
                            'title' => 'User Dashboard',
                            'route' => 'user.dashboard',
                            'icon'  => 'fa-dashboard',
                        ]);
                        $menu[] = $this->menuItem([
                            'tag'   => 'my_profile',
                            'title' => 'My Profile',
                            'route' => 'user.profile.show',
                        ]);
                    } else {
                        $adminDropdownMenu->children[] = $this->menuItem([
                            'tag'   => 'user_login',
                            'title' => 'User Login',
                            'route' => 'user.login',
                            'icon'  => 'fa-sign-in',
                        ]);
                    }
                }

                $adminDropdownMenu->children[] = $this->menuItem([
                    'tag'   => 'admin_logout',
                    'title' => 'Admin Logout',
                    'route' => 'admin.logout',
                    'icon'  => 'fa-sign-out',
                ]);
                if (!empty($this->user) && config('app.users_enabled')) {
                    $adminDropdownMenu->children[] = $this->menuItem([
                        'tag'   => 'user_logout',
                        'title' => 'User Logout',
                        'route' => 'user.logout',
                        'icon'  => 'fa-sign-out',
                    ]);
                }

                if ($this->isRootAdmin) {

                    foreach ($menu as $menuItem) {
                        if (property_exists($menuItem, 'tag') && ($menuItem->tag === 'db')) {
                            $adminDropdownMenu->children[] = $this->menuItem([
                                'tag'  => 'databases',
                                'title'=> 'Databases',
                                'route'=> 'admin.system.database.index',
                                'icon' => 'fa-database',
                            ]);
                            $adminDropdownMenu->children[] = $this->menuItem([
                                'tag'   => 'resources',
                                'title' => 'Resources',
                                'route' => 'admin.system.resource.index',
                                'icon'  => 'fa-table',
                            ]);
                        }
                    }
                }

                $menu[] = $adminDropdownMenu;

            } else {
                if (!$this->singleAdminMode) {
                    $menu[] = $this->menuItem([
                        'tag' => 'admin_login',
                        'title' => 'Admin Login',
                        'route' => 'admin.login',
                        'icon' => 'fa-sign-in',
                        'name' => 'admin-login',
                    ]);
                }
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
        $menuItem->table_name        = $data['table_name'] ?? null;
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
        $menuItem->is_public         = $data['is_public'] ?? 0;
        $menuItem->is_readonly       = $data['is_readonly'] ?? 0;
        $menuItem->is_root           = $data['is_root'] ?? 0;
        $menuItem->is_disabled       = $data['is_disabled'] ?? 0;
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
     * Returns the array of menu items for resources.
     *
     * @return array
     * @throws Exception
     */
    public function getResourceMenu(): array
    {
        // Create the array of menu items.
        $menu = [];

        foreach ($this->resourcesByDatabase as $database) {

            $database = $this->getDatabaseMenuItem($database);

            if (!empty($database['resources'])) {
                $childResources = [];
                foreach ($database['resources'] as $resource) {
                    $childResources[] = $this->getResourceMenuItem($resource);
                }

                $database['children'] = Collection::make($childResources);
            }

            $menu[] = $database;

        }

        return $menu;
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
                ->where('name', '=', 'job')
                ->where($this->envType->value, '=', 1)
                ->where('is_public', '=', 1)->count() == 0
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
        $menuItem->table_name     = null;
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
        $menuItem->is_public      = 1;
        $menuItem->is_readonly    = 0;
        $menuItem->is_root        = 0;
        $menuItem->is_disabled    = 0;
        $menuItem->is_demo        = 0;
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
     * Appends additional menu properties for a Database or AdminDatabase object.
     *
     * @param Database|AdminDatabase $database
     * @return Database|AdminDatabase
     * @throws Exception
     */
    public function getDatabaseMenuItem(Database|AdminDatabase $database): Database|AdminDatabase
    {
        $database['label']    = $database['title'];
        $database['children'] = [];

        return $database;
    }

    /**
     * Appends additional menu properties for a Resource or AdminResource object.
     *
     * @param Resource|AdminResource $resource
     * @return Resource|AdminResource
     */
    public function getResourceMenuItem(Resource|AdminResource $resource): Resource|AdminResource
    {
        $resource['label']    = $resource['title'];
        $resource['children'] = [];

        return $resource;
    }

    /**
     * @return void
     */
    #[NoReturn] protected function ddDebug(): void
    {
        if (!config('app.debug')) {
            abort(500, 'Unauthorized. .env setting APP_DEBUG must be set to true to view this page.');
        }

        dd([
            'singleAdminMode'     => $this->singleAdminMode,
            'envType'             => $this->envType->value,
            'owner'               => $this->owner,
            'admin'               => $this->admin,
            'user'                => $this->user,
            'resourcesByDatabase' => $this->resourcesByDatabase,
            'currentRoute'        => $this->currentRouteName,
            'showAll'             => $this->showAll,
            'publicAdminCount'    => $this->publicAdminCount,
        ]);
    }
}
