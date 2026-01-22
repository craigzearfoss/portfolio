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

    protected $perPage = 20;
    protected $PAGINATION_PER_PAGE = 40;
    protected $PAGINATION_BOTTOM = true;
    protected $PAGINATION_TOP = false;

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
        $params = Route::current()->parameters();

        $this->admin = loggedInAdmin();
        $this->user = loggedInUser();

        $this->owner = null;

        $currentRouteName = Route::currentRouteName();

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

        $parts = explode('.', $currentRouteName);
        $action = $parts[count($parts) - 1] ?? null;
        $resource = $parts[count($parts) - 2] ?? null;

        if (($resource == 'admin')
            && (in_array($action, ['show', 'edit']))
            && (array_key_exists('admin', $params))
            && (get_class($params['admin']) == 'App\Models\System\Admin')
        ) {
            $this->owner = $params['admin'];
        }

        if ($this->envType == PermissionService::ENV_ADMIN && !empty($this->admin)) {

            // in the admin environment and no current owner is selected then set it to the logged in admin
            Cookie::queue('owner_id', $this->admin->id, 60);
            if (empty($this->owner) || empty($this->admin->root)) {
                $this->owner = $this->admin;
            }

        } else {

            // update the owner that is currently being viewed
            if (!empty($params['admin']->id)) {

                // check for url parameter name "admin"
                Cookie::queue('owner_id', $params['admin']->id, 60);
                if (!empty($params['admin']->id)) $this->owner = Admin::find($params['admin']->id);

            } else {

                // check cookie named "owner_id"
                $ownerId = Cookie::get('owner_id', null);
                if (!empty($ownerId)) $this->admin = Admin::find($ownerId);
                if (empty($this->owner)) Cookie::queue('owner_id', null, 60);
            }
        }

        // update the user that is currently being viewed
        if (!empty($params['user']->id)) {

            // check for url parameter name "user"
            Cookie::queue('user_id', $params['user']->id, 60);

            if (!empty($params['user']->id)) {
                $this->user = User::find($params['user']->id);
            }

        } else {

            // check cookie named "user_id"
            $userId = Cookie::get('user_id', null);

            if (!empty($userId)) {
                $this->user = Admin::find($userId);
            }

            if (empty($this->user)) {
                Cookie::queue('user_id', null, 60);
            }
        }

        $this->owner = $this->getCurrentOwner();

        // inject variables into blade templates
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
     * This checks for the url parameter "owner_id" and if it is found it switched
     * the owner to that value.  It does this for the following environments:
     *      guest
     *      user
     *      admin - This only applies for root admins because the "owner_id" parameter
     *              is removed from the request object in the Admin middleware for
     *              admins that do not have root privileges. This is because we do
     *              not want non-root admins viewing and manipulating other users.
     *
     * @return mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCurrentOwner()
    {
        if ($ownerId = request()->get('owner_id')) {

            // only root admins can view different users
            if (empty($this->admin) || empty($this->admin->root)) {
                return null;
            }

            if (empty($this->admin->root) && ($ownerId != $this->admin->id)) {

                abort( 403, 'Access denied to owner ' . $ownerId . '.');

            } elseif (!$this->owner = Admin::where('id', $ownerId)->first()) {

                abort( 404, 'Owner ' . $ownerId . ' not found');

            } else {

                view()->share('owner', $this->owner);
            }
        }

        return $this->owner;
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
