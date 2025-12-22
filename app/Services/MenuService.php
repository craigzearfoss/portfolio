<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use stdClass;

class MenuService
{
    /**
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $envType
     * @param \App\Models\System\Admin|null $admin
     * @return array
     * @throws \Exception
     */
    public function getLeftMenu(string|null $envType = null, \App\Models\System\Admin|null $admin = null): array
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

        // Create the array of menu items.
        $menu = [];

        // add admin-specific and guest-specific items
        if (in_array($envType, [PermissionService::ENV_ADMIN, PermissionService::ENV_GUEST])) {

            // should we have a resume link?
            if ($resumeMenuItem = $this->getResumeMenuItem($envType, $currentRouteName, $admin, 1)) {
                $menu[] = $resumeMenuItem;
            }

            $currentDatabaseName = null;

            $i = 0;
            foreach (Resource::bySequence(null, $envType) as $resource) {

                // note that we skip some menu items
                if (!in_array($resource->database['name'], ['job'])) {

                    if (!empty($admin) || in_array($resource->database['name'], ['dictionary'])) {

                        if ($resource->database['name'] !== $currentDatabaseName) {
                            $currentDatabaseName = $resource->database['name'];
                            $i++;
                            $menu[$i] = $this->databaseItem($resource->database, $envType, $currentRouteName, $admin, 1);
                        }
                        $menu[$i]->children[] = $this->resourceItem($resource, $envType, $currentRouteName, $admin, 2);
                    }
                }
            }
        }

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
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $envType
     * @param \App\Models\System\Admin|null $admin
     * @return array
     * @throws \Exception
     */
    public function getTopMenu(string|null $envType = null, \App\Models\System\Admin|null $admin = null): array
    {
        // fo now the top menu is the same as the left menu
        return $this->getLeftMenu($envType, $admin);
    }

    /**
     * Returns the menu item for a database.
     *
     * @param array $database
     * @param string $envType
     * @param string $currentRouteName
     * @param \App\Models\System\Admin|null $admin
     * @param int $level
     * @return stdClass
     */
    public function databaseItem(
        array $database,
        string $envType,
        string $currentRouteName,
        \App\Models\System\Admin|null $admin = null,
        int $level = 1
    ): stdClass
    {
        if (!empty($database->global)) {
            $route = $envType.'.'.$database['name'].'.index';
            $link = Route::has($route) ? Route($route) : null;
        } else {
            switch ($envType) {
                case PermissionService::ENV_ADMIN:
                    $route = $envType.'.user.'.$database['name'].'.index';
                    $link = Route::has($route) ? Route($route, $admin) : null;
                    break;
                case PermissionService::ENV_USER:
                    break;
                case PermissionService::ENV_GUEST  :
                default:
                    if (empty($admin)) {
                        $route = $envType . '.' . $database['name'] . '.index';
                        $link = Route::has($route) ? Route($route) : null;
                    } else {
                        $route = $envType . '.admin.' . $database['name'] . '.show';
                        $link = Route::has($route) ? Route($route, $admin->label) : null;
                    }
                    break;
            }
        }

        $menuItem = new stdClass();
        $menuItem->id                = $database['id'] ?? null;
        $menuItem->level             = $level;
        $menuItem->name              = $database['name'] ?? null;
        $menuItem->database          = $database['database'] ?? null;
        $menuItem->table             = null;
        $menuItem->tag               = $database['tag'] ?? null;
        $menuItem->title             = $database['title'] ?? '';
        $menuItem->plural            = $database['plural'] ?? '';
        $menuItem->route             = $route;
        $menuItem->link              = $link;
        $menuItem->active            = $menuItem->route == $currentRouteName;
        $menuItem->guest             = $database['guest'] ?? 0;
        $menuItem->user              = $database['user'] ?? 0;
        $menuItem->admin             = $database['admin'] ?? 0;
        $menuItem->icon              = $database['icon'] ?? null;
        $menuItem->sequence          = $database['sequence'] ?? 0;
        $menuItem->public            = $database['public'] ?? 0;
        $menuItem->readonly          = $database['readonly'] ?? 0;
        $menuItem->root              = $database['root'] ?? 0;
        $menuItem->disabled          = $database['disabled'] ?? 0;
        $menuItem->admin_id          = $database['admin_id'] ?? null;
        $menuItem->children          = [];

        return $menuItem;
    }

    /**
     * Returns the menu item for a resource.
     * *
     * @param Resource $resource
     * @param string $envType
     * @param string $currentRouteName
     * @param \App\Models\System\Admin|null $admin
     * @param int $level
     * @return stdClass
     */
    public function resourceItem(
        Resource $resource,
        string $envType,
        string $currentRouteName,
        \App\Models\System\Admin|null $admin = null,
        int $level = 1): stdClass
    {
        if (!empty($resource->global)) {

            $route = $envType.'.'.$resource->database['name'].'.'.$resource['name'].'.index';
            $link = Route::has($route) ? Route($route) : null;

        } else {

            if ($envType == PermissionService::ENV_GUEST) {
                $route = $envType.'.admin.'.$resource->database['name'].'.'.$resource['name'].'.index';
                $link = Route::has($route) ? Route($route, $admin->label) : null;
            } else {
                $route = $envType.'.'.$resource->database['name'].'.'.$resource['name'].'.index';;
                $link = Route::has($route) ? Route($route) : null;
            }
        }

        $menuItem = new stdClass();
        $menuItem->id                = $resource->id ?? null;
        $menuItem->level             = $level;
        $menuItem->name              = $resource->name ?? null;
        $menuItem->database          = $resource->database ?? null;
        $menuItem->table             = $resource->table ?? null;
        $menuItem->tag               = null;
        $menuItem->title             = $resource->title ?? '';
        $menuItem->plural            = $resource->plural ?? '';
        $menuItem->route             = $route;
        $menuItem->link              = $link;
        $menuItem->active            = $menuItem->route == $currentRouteName;
        $menuItem->guest             = $resource->guest ?? 0;
        $menuItem->user              = $resource->user ?? 0;
        $menuItem->admin             = $resource->admin ?? 0;
        $menuItem->icon              = $resource->icon ?? null;
        $menuItem->sequence          = $resource->sequence ?? 0;
        $menuItem->public            = $resource->public ?? 0;
        $menuItem->readonly          = $resource->readonly ?? 0;
        $menuItem->root              = $resource->root ?? 0;
        $menuItem->disabled          = $resource->disabled ?? 0;
        $menuItem->admin_id          = $resource->admin ?? null;
        $menuItem->db_id             = $resource->database['id'] ?? null;
        $menuItem->db_name           = $resource->database['name'] ?? null;
        $menuItem->db_database       = $resource->database['database'] ?? null;
        $menuItem->db_tag            = $resource->database['tag'] ?? null;
        $menuItem->db_title          = $resource->database['title'] ?? null;
        $menuItem->db_plural         = $resource->database['plural'] ?? null;
        $menuItem->children          = [];

        return $menuItem;
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
        $menuItem->link              = Route::has($menuItem->route) ? Route($menuItem->route) : null;
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
     * Returns a menu item.
     * *
     * @param string $envType
     * @param string|null $currentRouteName
     * @param \App\Models\System\Admin|null $admin
     * @param int $level
     * @return stdClass|null
     */
    public function getResumeMenuItem(
        string $envType,
        string|null $currentRouteName = null,
        \App\Models\System\Admin|null $admin = null,
        int $level = 1): stdClass|null
    {
        if (empty($admin)) {
            return null;
        }

        if (Resource::withoutGlobalScope(AdminPublicScope::class)
            ->where('name', 'job')->where($envType, 1)->where('public', 1)->count() == 0
        ) {
            return false;
        }

        try {
            $resumeRoute = route('guest.admin.resume', $admin);
        } catch (\Throwable $th) {
            return null;
        }

        $menuItem = new stdClass();
        $menuItem->id       = null;
        $menuItem->level    = $level;
        $menuItem->name     = 'Resume';
        $menuItem->database = null;
        $menuItem->table    = null;
        $menuItem->tag      = null;
        $menuItem->title    = 'Resume';
        $menuItem->plural   = 'Resumes';
        $menuItem->route    = $resumeRoute;
        $menuItem->link     = $resumeRoute;
        $menuItem->active   = $resumeRoute == $currentRouteName;
        $menuItem->guest    = $envType == 'guest' ? 1 : 0;
        $menuItem->user     = $envType == 'user' ? 1 : 0;
        $menuItem->admin    = $envType == 'admin' ? 1 : 0;
        $menuItem->icon     = null;
        $menuItem->sequence = 0;
        $menuItem->public   = 1;
        $menuItem->readonly = 0;
        $menuItem->root     = 0;
        $menuItem->disabled = 0;
        $menuItem->admin_id = null;
        $menuItem->children = [];

        return $menuItem;
    }
}
