<?php

namespace App\Http\Controllers;

use App\Enums\EnvTypes;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\Resource;
use App\Models\System\User;
use App\Services\CookieManagerService;
use App\Services\MenuService;
use App\Services\PermissionService;
use Exception;
use http\Env;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\NoReturn;

/**
 *
 */
class BaseController extends Controller
{
    /**
     * The environment type of the current page. (guest / user /admin)
     */
    protected EnvTypes|null $envType = null;

    /**
     * The logged in admin, logged-in user, and current owner that is being viewed.
     */
    protected Admin|Owner|null $admin = null;

    /**
     * @var Admin|Owner|null
     */
    protected Admin|Owner|null $owner = null;

    /**
     * @var int|null
     */
    protected int|null $owner_id = null;

    /**
     * @var User|null
     */
    protected User|null $user = null;

    /**
     * @var string|null
     */
    protected ?string $resourceType = null;

    /**
     * @var PermissionService|null
     */
    protected ?PermissionService $permissionService = null;

    /**
     * @var MenuService|null
     */
    protected ?MenuService $menuService = null;

    /**
     * @var CookieManagerService|null
     */
    protected ?CookieManagerService $cookieManager = null;

    /**
     * @var int
     */
    protected int $PAGINATION_PER_PAGE = 20;

    /**
     * @param PermissionService $permissionService
     * @param EnvTypes $envType
     * @throws Exception
     */
    public function __construct(PermissionService $permissionService, EnvTypes $envType = EnvTypes::GUEST)
    {
        $this->permissionService = $permissionService;

        $this->cookieManager = new CookieManagerService();

        $this->envType      = $envType;
        $this->resourceType = $this->getResourceTypeFromRoute();
        $this->admin        = loggedInAdmin();
        $this->user         = loggedInUser();
        $this->owner        = $this->getOwner($this->admin);

        // set owner_id cookie
        $this->cookieManager->setOwnerId($this->envType, $this->owner->id ?? null);
        $this->cookieManager->queueOwnerId($this->envType, 60);

        // get the menu service
        $this->menuService = new MenuService(
            $this->envType,
            $this->owner,
            $this->admin,
            $this->user,
        );

        if (request()->has('debug')) {
            $this->ddDebug();
        }

        // inject variables into blade templates
        view()->share('envType', $this->envType);
        view()->share('admin', $this->admin);
        view()->share('owner', $this->owner);
        view()->share('user', $this->user);
        view()->share('menuService', $this->menuService);

        // inject pagination variables into blade templates
        view()->share('pagination_bottom', config('app.pagination_bottom'));
        view()->share('pagination_top', config('app.pagination_top'));
        view()->share('bottom_column_headings', config('app.bottom_column_headings'));
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

        $this->admin        = loggedInAdmin();
        $this->user         = loggedInUser();
        $this->owner        = $this->getOwner($this->admin, $this->envType);
        $this->resourceType = $this->getResourceTypeFromRoute();

        // save owner cookie
        $this->cookieManager->setOwnerId($this->envType, $this->owner->id ?? null);
        $this->cookieManager->queueOwnerId($this->envType, 60);

        // get the menu service
        $this->menuService = new MenuService(
            $this->envType,
            $this->owner,
            $this->admin,
            $this->user,
        );

        // inject variables into blade templates
        view()->share('envType', $this->envType);
        view()->share('admin', $this->admin);
        view()->share('owner', $this->owner);
        view()->share('user', $this->user);
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

    private function getOwner($currentAdmin, $envType = EnvTypes::GUEST)
    {
        $owner = null;

        if (($envType == EnvTypes::ADMIN) && !isRootAdmin()) {

            // this is a non-root admin so they can only view their own resources
            return $currentAdmin;
        }

        // get the "owner_id" url parameter, if there is one
        $owner_id = request()->query('owner_id');
        if (!request()->has('owner_id')) {
            $owner_id = null;
        } else {
            if (request()->query('owner_id') === '*') {
                $owner_id = '*';
            } else {
                $owner_id = intval($owner_id);
            }
        }

        if (!empty($owner_id)) {

            if ($owner_id !== '*') {
                $owner = new Admin()->find($owner_id);
            }

        } elseif ($admin = Route::current()->parameter('admin')) {

            if (!empty($admin)) {
                if (is_string($admin)) {
                    $owner = new Admin()->find($admin);
                } else {
                    $owner = $admin;
                }
            }

        } elseif (!in_array(Route::currentRouteName(), [
            'guest.index',
            'guest.admin.index',
            'admin.index',
            'admin.dashboard',
            'admin.system.admin.index',
        ])) {

            if ($owner_id = $this->cookieManager->getOwnerId($this->envType)) {

                $owner = new Admin()->find($owner_id);

            } elseif (!empty($currentAdmin)) {

                $owner = $currentAdmin;
            }
        }

        return $owner;
    }

    /**
     * @return void
     */
    #[NoReturn] protected function ddDebug()
    {
        if (!config('app.debug')) {
            abort(500, 'Unauthorized. .env setting APP_DEBUG must be set to true to view this page.');
        }

        dd([
            'envType'              => $this->envType->value,
            'currentRouteName'     => Route::currentRouteName(),
            'action'               => Route::currentRouteAction(),
            'routeParams'          => Route::current()->parameters(),
            'urlParams'            => array_filter(
                                          request()->query(),
                                          function($key) {
                                              return $key != 'debug';
                                          },
                                    ARRAY_FILTER_USE_KEY
                                      ),
            'cookies'              => request()->cookie(),
            'resourceType'         => $this->resourceType,

            'admin->id'            => $this->admin->id ?? null,
            'admin->username'      => $this->admin->username ?? null,
            'admin'                => $this->admin,

            'user->id'             => $this->user->id ?? null,
            'user->username'       => $this->user->username ?? null,
            'user'                 => $this->user,

            'owner->id'            => $this->owner->id ?? null,
            'owner->username'      => $this->owner->username ?? null,
            'owner'                => $this->owner,

            'menuService'          => $this->menuService,
        ]);
    }

    /**
     * Returns the resource type (database_name.resource_name) as determined from the route name.
     *
     * @return string|null
     */
    protected function getResourceTypeFromRoute(): ?string
    {
        $resourceType = '';

        $routeParts = explode('.', Route::currentRouteName());

        if ($routeParts[0] == 'guest') {

            $resourceModel = new Resource();

            if ((count($routeParts) > 1) && ($routeParts[1] == 'admin')) {
                if ($resource = $resourceModel->getResourceByName('system', 'admin')) {
                    $resourceType = $resource['database_name'] . '.' . $resource['name'];
                }
            } elseif (count($routeParts) > 2) {
                if ($resource = $resourceModel->getResourceByName($routeParts[1], $routeParts[2])) {
                    $resourceType = $resource['database_name'] . '.' . $resource['name'];
                }
            }

        }

        return $resourceType;
    }
}
