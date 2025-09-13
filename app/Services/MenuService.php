<?php

namespace App\Services;

use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use stdClass;

class MenuService
{
    /**
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $userType
     * @return array
     * @throws \Exception
     */
    public function getLeftMenu(string|null $userType = null): array
    {
        // Verify the user type.
        if (empty($userType)) {
            $userType = PermissionService::currentUserType();
        }
        if (!in_array($userType, PermissionService::USER_TYPES)) {
            throw new \Exception('Invalid current user type');
        }

        // Get the name of the current route.
        $currentRouteName = Route::currentRouteName();

        // Create the array of menu items.
        $menu = [];
        $currentDatabaseName = null;
        $i = -1;
        foreach ((new Resource())->bySequence($userType) as $resource) {
            if ($resource->database['name'] !== $currentDatabaseName) {
                $currentDatabaseName = $resource->database['name'];
                $i++;
                $menu[$i] = $this->databaseItem($resource->database, $userType, $currentRouteName);
            } else {
                $menu[$i]->children[] = $this->resourceItem($resource, $userType, $currentRouteName);
            }
        }

        if (Auth::guard('admin')->check()) {

            $menu[] = $this->menuItem(
                [ 'title' => 'Admin Dashboard', 'route'    => 'admin.dashboard' ],
                $currentRouteName
            );

            $menu[] = $this->menuItem(
                [ 'title' => 'User Dashboard', 'route'    => 'user.dashboard' ],
                $currentRouteName
            );

            $menu[] = $this->menuItem(
                [ 'title' => 'My Profile', 'route'    => 'admin.profile.show' ],
                $currentRouteName
            );

            /*
            $menu[] = $this->menuItem(
                [ 'title'=> 'Change Password', 'route' => 'admin.profile.change-password' ],
                $currentRouteName
            );
            */

            $menu[] = $this->menuItem(
                [ 'title'=> 'Logout', 'route' => 'admin.logout' ],
                $currentRouteName
            );

            if (Auth::guard('admin')->user()->root) {

                for ($i=0; $i<count($menu); $i++) {
                    if (property_exists($menu[$i],'tag') && ($menu[$i]->tag === 'db')) {

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Databases', 'route' => 'admin.database.index', 'icon' => 'fa-database' ],
                            $currentRouteName
                        );

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Resources', 'route'    => 'admin.resource.index', 'icon' => 'fa-table' ],
                            $currentRouteName
                        );
                    }
                }
            }

        } elseif (Auth::guard('web')->check()) {

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
                [ 'name' => 'user-login', 'title'=> 'User Login', 'route' => 'front.login' ],
                $currentRouteName
            );

            $menu[] = $this->menuItem(
                [ 'name' => 'admin-login', 'title'=> 'Admin Login', 'route' => 'admin.login' ],
                $currentRouteName
            );

        }

        return $menu;
    }

    /**
     * Returns the array of items for the left nav menu.
     *
     * @param string|null $userType
     * @return array
     * @throws \Exception
     */
    public function getTopMenu(string|null $userType = null): array
    {
        // Verify the user type.
        if (empty($userType)) {
            $userType = PermissionService::currentUserType();
        }
        if (!in_array($userType, PermissionService::USER_TYPES)) {
            throw new \Exception('Invalid current user type');
        }

        // Get the name of the current route.
        $currentRouteName = Route::currentRouteName();

        // Create the array of menu items.
        $menu = [];
        $currentDatabaseName = null;
        $i = -1;
        foreach ((new Resource())->bySequence($userType) as $resource) {
            if ($resource->database['name'] !== $currentDatabaseName) {
                $currentDatabaseName = $resource->database['name'];
                $i++;
                $menu[$i] = $this->databaseItem($resource->database, $userType, $currentRouteName);
            } else {
                $menu[$i]->children[] = $this->resourceItem($resource, $userType, $currentRouteName);
            }
        }

        if (Auth::guard('admin')->check()) {

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

            if (Auth::guard('admin')->user()->root) {

                for ($i=0; $i<count($menu); $i++) {
                    if (property_exists($menu[$i],'tag') && ($menu[$i]->tag === 'db')) {

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Databases', 'route'    => 'admin.database.index', 'icon' => 'fa-database' ],
                            $currentRouteName
                        );

                        $menu[$i]->children[] = $this->menuItem(
                            [ 'title' => 'Resources', 'route'    => 'admin.resource.index', 'icon' => 'fa-table' ],
                            $currentRouteName
                        );
                    }
                }
            }

        } elseif (Auth::guard('web')->check()) {

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
                [ 'title'=> 'User Login', 'route' => 'front.login' ],
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
     * Returns the menu item for a database.
     *
     * @param array $database
     * @param string $userType
     * @param string $currentRouteName
     * @return stdClass
     */
    public function databaseItem(array $database, string $userType, string $currentRouteName): stdClass
    {
        $routePrefix = in_array($userType, [PermissionService::USER_TYPE_GUEST]) ? '' : $userType . '.';

        $menuItem = new stdClass();
        $menuItem->id                = $database['id'] ?? null;
        $menuItem->name              = $database['name'] ?? null;
        $menuItem->database          = $database['database'] ?? null;
        $menuItem->table             = null;
        $menuItem->tag               = $database['tag'] ?? null;
        $menuItem->title             = $database['title'] ?? '';
        $menuItem->plural            = $database['plural'] ?? '';
        $menuItem->route             = $routePrefix . $database['name'] . '.index';
        $menuItem->link              = Route::has($menuItem->route) ? Route($menuItem->route) : null;
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
     * @param string $userType
     * @param string $currentRouteName
     * @return stdClass
     */
    public function resourceItem(Resource $resource, string $userType, string $currentRouteName): stdClass
    {
        $routePrefix = in_array($userType, [PermissionService::USER_TYPE_GUEST]) ? '' : $userType . '.';
        if ($resource->database['tag'] !== 'db') {
            $routePrefix .= $resource->database['name'] . '.';
        }

        $menuItem = new stdClass();
        $menuItem->id                = $resource->id ?? null;
        $menuItem->name              = $resource->name ?? null;
        $menuItem->database          = $resource->database ?? null;
        $menuItem->table             = $resource->table ?? null;
        $menuItem->tag               = null;
        $menuItem->title             = $resource->title ?? '';
        $menuItem->plural            = $resource->plural ?? '';
        $menuItem->route             = $routePrefix . $resource['name'] . '.index';
        $menuItem->link              = Route::has($menuItem->route) ? Route($menuItem->route) : null;
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
     * @return stdClass
     */
    public function menuItem(array $data, string $currentRouteName): stdClass
    {
        $menuItem = new stdClass();
        $menuItem->id                = $data['id'] ?? null;
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
}
