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
    const OWNER_ID_COOKIE = 'owner_id';
    const USER_ID_COOKIE = 'user_id';

    /**
     * The environment type of the current page. (guest / user /admin)
     */
    protected $envType = null;

    /**
     * The logged in admin, logged-in user, and current owner that is being viewed.
     */
    protected $admin = null;
    protected $user  = null;

    protected $owner = null;

    protected $action            = null;
    protected $currentRouteName  = null;
    protected $routeParams       = [];
    protected $urlParams         = [];
    protected $resource          = null;

    protected $cookies           = [];

    protected $permissionService = null;
    protected $menuService       = null;

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
    protected function initialize($envTpe = PermissionService::ENV_GUEST)
    {
        $this->envType = $envTpe;

        $this->admin = loggedInAdmin();
        $this->user  = loggedInUser();

        $this->owner = null;

        // get the url/route information
        $this->action           = Route::currentRouteAction();
        $this->currentRouteName = Route::currentRouteName();
        $this->routeParams      = Route::current()->parameters();
        $this->urlParams        = request()->all();
        $parts                  = explode('.', $this->currentRouteName);
        $this->resource         = $parts[count($parts) - 2] ?? null;

        // get cookies
        $this->cookies = [
            'owner_id' => Cookie::get(self::OWNER_ID_COOKIE, null),
            'user_id'  => Cookie::get(self::USER_ID_COOKIE, null),
        ];

        // get the "owner_id" url parameter, if there is one
        $owner_id = isset($this->urlParams['owner_id']) ? $this->urlParams['owner_id'] : null;
        if (!is_null($owner_id) && (empty($owner_id) || ($owner_id == '*'))) {
            $owner_id = '*';
        } elseif (filter_var($owner_id, FILTER_VALIDATE_INT) !== false) {
            $owner_id = intval($owner_id);
        }

        // ---------------------
        // set the current owner
        // ---------------------
        if (($this->envType == PermissionService::ENV_ADMIN) && !empty($this->admin) && empty($this->admin->root)) {

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

        } elseif (!empty($this->routeParams['admin'])) {

            $this->owner = $this->routeParams['admin'];
            $owner_id = $this->owner->id;

        //} elseif ($this->currentRouteName == 'guest.index') {
        //
        //    // home page
        //    $this->owner = null;
        //    $owner_id = null;

        } else {

            if (empty($this->owner)) {
                // get the owner_id from the cookie
                if ($owner_id = $this->cookies['owner_id']) {
                    $this->owner = Admin::find($owner_id);
                    $owner_id = $this->owner->id;
                } else {
                    $this->owner = null;
                }
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
        Cookie::queue(self::OWNER_ID_COOKIE, $owner_id, 60);

        // --------------------
        // set the current user
        // --------------------
        if (array_key_exists('user_id', $this->urlParams)) {
            // there is a "user_id" url parameter
            $user_id = (!empty($this->urlParams['user_id'])) ? $this->urlParams['user_id'] : null;
            if (!$this->user = Admin::find($user_id)) {
                abort(404, 'User ' . $user_id . ' not found.');
            }
        } else {

            $userFromRoute = (($this->resource == 'user') && in_array($this->action, ['show', 'edit']))
            && !empty($this->routeParams['user'])
            && is_object($this->routeParams['user'])
            && (get_class($this->routeParams['user']) == 'App\Models\System\User')
                ? $this->routeParams['user']
                : null;

            if (!empty($userFromRoute)) {
                // this is a user show or edit page
                $this->user = $userFromRoute;
                $user_id = $this->user->id;

            } else {
                // get the user_id from the cookie
                if ($user_id = $this->cookies['user_id']) {
                    $this->user = User::find($user_id);
                } else {
                    $this->user = null;
                }
            }
        }
        Cookie::queue(self::USER_ID_COOKIE, $user_id, 60);

        $this->menuService = new MenuService(
            $this->envType,
            $this->owner,
            $this->admin,
            $this->user,
            $this->currentRouteName
        );

        // inject variables into blade templates
        view()->share('envType', $this->envType);
        view()->share('admin', $this->admin);
        view()->share('user', $this->user);
        view()->share('owner', $this->owner);
        view()->share('menuService', $this->menuService);

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

    protected function ddDebug()
    {
        dd([
            'envType'              => $this->envType,
            'currentRouteName'     => $this->currentRouteName,
            'action'               => $this->action,
            'resource'             => $this->resource,
            'routeParams'          => $this->routeParams,
            'urlParams'            => $this->urlParams,
            'cookies'              => $this->cookies,
            'admin'                => $this->admin,
            'user'                 => $this->user,
            'owner'                => $this->owner,
            'menuService'          => $this->menuService,
        ]);
    }

    public function permissionGate()
    {
        return true;
    }
}
