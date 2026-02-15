<?php

namespace App\Http\Controllers;

use App\Enums\EnvTypes;
use App\Models\System\Admin;
use App\Models\System\User;
use App\Services\MenuService;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\NoReturn;

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
    protected $owner = null;
    protected $owner_id = null;
    protected $isRootAdmin = false;
    protected $user  = null;

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
     * @throws Exception
     */
    protected function initialize($envType = EnvTypes::GUEST)
    {
        $this->envType = $envType;

        $this->admin       = loggedInAdmin();
        $this->isRootAdmin = !empty($this->admin->root);
        $this->owner       = null;
        $this->user        = loggedInUser();

        // get the url/route information
        $this->action           = Route::currentRouteAction();
        $this->currentRouteName = Route::currentRouteName();
        $this->routeParams      = Route::current()->parameters();
        $this->urlParams        = array_filter(
            request()->query(),
            function ($value, $key) { return !empty($value); },
            ARRAY_FILTER_USE_BOTH
        );
        $parts                  = explode('.', $this->currentRouteName);
        $this->resource         = $parts[count($parts) - 2] ?? null;

        $adminModel = new Admin();

        // get cookies
        $this->cookies = [
            'owner_id' => Cookie::get(self::OWNER_ID_COOKIE),
            'user_id'  => Cookie::get(self::USER_ID_COOKIE),
        ];

        // get the "owner_id" url parameter, if there is one
        $owner_id = $this->urlParams['owner_id'] ?? null;
        if (!is_null($owner_id) && (empty($owner_id) || ($owner_id == '*'))) {
            $owner_id = '*';
        } elseif (filter_var($owner_id, FILTER_VALIDATE_INT) !== false) {
            $owner_id = intval($owner_id);
        }

        // ---------------------
        // set the current owner
        // ---------------------
        if (($this->envType == EnvTypes::ADMIN) && !empty($this->admin) && empty($this->admin->root)) {

            // this is a non-root admin so they can only view their own resources
            $this->owner = $this->admin;
            $owner_id = $this->owner->id;

        } elseif ($owner_id == '*') {

            // owner_id=* or owner_id= passed in url parameter
            $this->owner = null;
            $owner_id = null;

        } elseif (!empty($owner_id)) {

            // valid owner_id url parameter passed in
            if ($this->owner = $adminModel->find($owner_id)) {
                $owner_id = $this->owner->id;
            } else {
                $owner_id = null;
            }

        } elseif (!empty($this->routeParams['admin']) && is_string($this->routeParams['admin'])) {

            if ($this->owner = $adminModel->find($this->routeParams['admin']) ) {
                $owner_id = $this->owner->id;
            } else {
                $owner_id = null;
            }

        } elseif (!empty($this->routeParams['admin'])) {

            if ($this->owner = $this->routeParams['admin']) {
                $owner_id = $this->owner->id;
            } else {
                $owner_id = null;
            }

        //} elseif ($this->currentRouteName == 'guest.index') {
        //
        //    // home page
        //    $this->owner = null;
        //    $owner_id = null;

        } elseif (!empty($this->admin)) {

            $this->owner = $this->admin;
            $owner_id = $this->owner->id ?? null;

        } else {

            if (empty($this->owner)) {
                // get the owner_id from the cookie
                if ($owner_id = $this->cookies['owner_id']) {
                    $this->owner = $adminModel->find($owner_id);
                    $owner_id = $this->owner->id;
                } else {
                    $this->owner = null;
                }
            }
        }

        if (empty($this->owner)
            && ($this->envType == EnvTypes::ADMIN)
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
            if (!$this->user = $adminModel->find($user_id)) {
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
                    $this->user = new User()->find($user_id);
                } else {
                    $this->user = null;
                }
            }
        }
        Cookie::queue(self::USER_ID_COOKIE, $user_id, 60);

        $this->menuService = new MenuService(
            $this->envType,
            $this->isRootAdmin ? null : $this->owner,
            $this->admin,
            $this->user,
            $this->currentRouteName
        );

        // inject variables into blade templates
        view()->share('envType', $this->envType);
        view()->share('admin', $this->admin);
        view()->share('isRootAdmin', $this->isRootAdmin);
        view()->share('owner', $this->owner);
/*
        view()->share('owner', $this->owner
            ? (!empty($this->urlParams['owner_id']) ? $this->owner : null)
            : $this->owner);
*/
        view()->share('user', $this->user);
        view()->share('menuService', $this->menuService);
        view()->share('urlParams', $this->urlParams);

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

    #[NoReturn] protected function ddDebug()
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
}
