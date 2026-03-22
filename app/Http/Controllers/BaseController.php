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
     * Does the current admin have root permissions?
     */
    protected bool $isRootAdmin = false;

    /**
     * @var Admin|Owner|null
     */
    protected Admin|Owner|null $owner = null;

    /**
     * @var int|null
     */
    protected int|null $owner_id = null;

    /**
     * @var int
     */
    protected int $publicAdminCount = 0;

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

        $this->envType          = $envType;
        $this->resourceType     = $this->getResourceTypeFromRoute();
        $this->admin            = loggedInAdmin();
        $this->isRootAdmin      = $this->admin->is_root ?? false;
        $this->user             = loggedInUser();
        $this->owner            = $this->getOwner($this->admin);
        $this->publicAdminCount = new Admin()->where('is_public', '=', true)
            ->where('is_disabled', '=', false)
            ->count();

        // set owner_id cookie
        $this->cookieManager->setOwnerId($this->envType, $this->owner->id ?? null);
        $this->cookieManager->queueOwnerId($this->envType);

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
        view()->share('isRootAdmin', $this->isRootAdmin);
        view()->share('owner', $this->owner);
        view()->share('publicAdminCount', $this->publicAdminCount);
        view()->share('user', $this->user);
        view()->share('menuService', $this->menuService);

        // inject pagination variables into blade templates
        view()->share('pagination_bottom', config('app.pagination_bottom'));
        view()->share('pagination_top', config('app.pagination_top'));
        view()->share('top_column_headings', config('app.top_column_headings'));
        view()->share('bottom_column_headings', config('app.bottom_column_headings'));
    }

    /**
     * Returns the number of items per page for pagination. First it checks the
     * PAGINATION_PER_PAGE variable in the .env file. If it is not set then it
     * get the value of the PAGINATION_PER_PAGE class  variable in the controller.
     *
     * @return int
     */
    public function perPage(): int
    {
        $perPage = config('app.pagination_per_page');

        if (empty($perPage)) {
            $perPage = $this->PAGINATION_PER_PAGE;
        }

        return $perPage;
    }

    /**
     * Get the current owner.
     *
     * @param Admin|Owner|null $currentAdmin
     * @return Admin|Owner|null
     */
    private function getOwner(Admin|Owner|null $currentAdmin): Admin|Owner|null
    {
        $owner = null;
        $envType = !empty($this->envType) ? $this->envType : getEnvType();
        $ownerIdSpecified = false;

        // on the guest home page set the owner to null
        if (($envType === EnvTypes::GUEST) && (Route::currentRouteName() === 'guest.index')) {
            if (!config('app.single_admin_mode')) {
                return null;
            }
        }

        // for APP_SINGLE_ADMIN_MODE the owner is always the FEATURED_ADMIN as specified in the .env file
        if (config('app.single_admin_mode')) {
            if (!$featuredAdminUsername = config('app.featured_admin_username')) {
                abort(500, 'APP_FEATURED_ADMIN_USERNAME must be specified in .env file when APP_SINGLE_ADMIN_MODE is set.');
            }
            if (!$featuredAdmin = new Admin()->firstWhere('username', $featuredAdminUsername)) {
                abort(500, 'Featured admin ' . $featuredAdminUsername . ' does not exist.');
            } else {
                return $featuredAdmin;
            }
        }

        if (($envType->value == 'admin') && !empty($currentAdmin) && !$currentAdmin['is_root']) {
            // this is a non-root admin so they can only view their own resources
            return $currentAdmin;
        }

        // get the "owner_id" url parameter, if there is one
        if (request()->exists('owner_id')) {

            $ownerIdSpecified = true;
            $owner_id = request()->query('owner_id');

            if (empty($owner_id) || in_array($owner_id, ['*', 'all'])) {
                $owner_id = null;
            } else {
                $owner_id = intval($owner_id);
                $owner = Admin::findOrFail($owner_id);
            }

            if (!$this->isRootAdmin) {
                request()->query->remove('owner_id');
                }
        }

        if (!$ownerIdSpecified) {

            if ($admin = Route::current()->parameter('admin')) {

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

            if (empty($owner)) {

                if ($envType->value == 'guest') {

                    $parameters = Route::current()->parameters();
                    if (!empty($parameters['admin'])) {

                        return new Admin()->where('label', '=', $parameters['admin'])->first();

                    } elseif ($featuredAdminUsername = config('app.featured_admin_username')) {

                        return new Admin()->where('username', '=', $featuredAdminUsername)->first();
                    }

                } elseif ($envType->value == 'admin') {
                    $owner = $currentAdmin;
                }
            }
        }

        return $owner;
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
