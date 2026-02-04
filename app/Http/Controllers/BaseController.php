<?php

namespace App\Http\Controllers;

use App\Models\System\Admin;
use App\Models\System\User;
use App\Services\MenuService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller
{
    protected $permissionService;

    /**
     * The environment type of the current page. (guest / user /admin)
     */
    protected $envType = null;

    /**
     * The logged in admin, logged-in user, and current owner that is being viewed.
     */
    protected $admin = null;
    protected $user = null;
    protected $owner = null;

    protected $PAGINATION_PER_PAGE = 20;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Sets the following controller class variables and view variables of the same name.
     *      loggedInAdmin - The admin that is currently logged in.
     *      admin         - The admin that is currently being viewed.
     *
     * @return void
     * @throws \Exception
     */
    protected function setCurrentAdminAndUser()
    {
        $this->admin = loggedInAdmin();
        $this->user = loggedInUser();

        $this->owner = null;

        $currentRouteName = Route::currentRouteName();
        $routeParams = Route::current()->parameters();
        $urlParams = request()->all();

        // get the environment
        switch (explode('.', $currentRouteName)[0]) {
            case 'admin':
                $this->envType = PermissionService::ENV_ADMIN;
                break;
            case 'user':
                $this->envType = PermissionService::ENV_USER;
                break;
            case 'guest':
            default:
                $this->envType = PermissionService::ENV_GUEST;
                break;
        }

        $ownerIdCookieName = $this->envType . '_owner_id';
        $userIdCookieName = $this->envType . '_user_id';

        $parts = explode('.', $currentRouteName);
        $action = $parts[count($parts) - 1] ?? null;
        $resource = $parts[count($parts) - 2] ?? null;

        // get the "owner_id" url parameter, if there is one
        $owner_id = isset($urlParams['owner_id']) ? $urlParams['owner_id'] : null;
        if (!is_null($owner_id)) {
            if (empty($owner_id) || ($owner_id == '*')) {
                $owner_id = '*';
            }
        } elseif (filter_var($owner_id, FILTER_VALIDATE_INT) !== false) {
            $owner_id = intval($owner_id);
        }

        // ---------------------
        // set the current owner
        // ---------------------
        if (($this->envType == 'admin') && !empty($this->admin)  && empty($this->admin->root)) {

            // this is a non-root admin so they can only view their own resources
            $this->owner = $this->admin;
            $owner_id = $this->owner->id;

        } elseif ($owner_id == '*') {

            // owner_id=* or owner_id= passed in url parameter
            $this->owner = null;
            $owner_id = null;

        } elseif (!empty($owner_id)) {

            // valid owner_id url parameter passed in
            if ($this->owner = Admin::find($owner_id)) {
                $owner_id = $this->owner->id;
            } else {
                $owner_id = null;
            }

        } else {

            // get the owner_id from the cookie
            if ($owner_id = Cookie::get($ownerIdCookieName, null)) {
                $this->owner = Admin::find($owner_id);
            } else {
                $this->owner = null;
            }
        }

        if (empty($this->owner)
            && ($this->envType == PermissionService::ENV_ADMIN)
            && !empty($this->admin)
            && empty($this->admin->root)
        )  {
            $this->owner = $this->admin;
            $owner_id = $this->admin->id;
        }
        Cookie::queue($ownerIdCookieName, $owner_id, 60);

        // --------------------
        // set the current user
        // --------------------
        if (array_key_exists('user_id', $urlParams)) {
            // there is a "user_id" url parameter
            $user_id = (!empty($urlParams['user_id'])) ? $urlParams['user_id'] : null;
            if (!$this->user = Admin::find($user_id)) {
                abort(404, 'User ' . $user_id . ' not found.');
            }
        } else {

            $userFromRoute = (($resource == 'user') && in_array($action, ['show', 'edit']))
            && !empty($routeParams['user'])
            && is_object($routeParams['user'])
            && (get_class($routeParams['user']) == 'App\Models\System\User')
                ? $routeParams['user']
                : null;
            //dd(['envType'=>$this->envType, 'resource'=>$resource, 'action'=>$action, 'routeParams'=>$routeParams, 'userFromRoute'=>$userFromRoute]);

            if (!empty($userFromRoute)) {
                // this is a user show or edit page
                $this->user = $userFromRoute;
                $user_id = $this->user->id;

            } else {
                // get the user_id from the cookie
                if ($user_id = Cookie::get($userIdCookieName, null)) {
                    $this->user = User::find($user_id);
                } else {
                    $this->user = null;
                }
            }
        }
        Cookie::queue($userIdCookieName, $user_id, 60);

        // inject variables into blade templates
        view()->share('envType', $this->envType);
        view()->share('admin', $this->admin);
        view()->share('user', $this->user);
        view()->share('owner', $this->owner);
        view()->share('menuService', new MenuService($this->envType,
                                                     $this->owner,
                                                     $this->admin,
                                                     $this->user,
                                                     $currentRouteName
        ));

        // inject pagination variables into blade templates
        view()->share('pagination_bottom', config('app.pagination_bottom'));
        view()->share('pagination_top', config('app.pagination_top'));
        view()->share('bottom_column_headings', config('app.bottom_column_headings'));
    }

    /**
     * Returns the number of items per page for pagination. First it checks the
     * PAGINATION_PER_PAGE variable in the .env file. If it is not set then it
     * get the value of the PAGINATION_PER_PAGE class  variable in the controller.
     *
     * @return int
     */
    public function perPage()
    {
        $perPage = config('app.pagination_per_page');

        if (empty($perPage)) {
            $perPage = intval($this->PAGINATION_PER_PAGE);
        }

        return $perPage;
    }

    public function permissionGate()
    {
        return true;
    }
}
