<?php

namespace App\Http\Controllers;

use App\Models\System\Admin;
use App\Models\System\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller
{
    protected $permissionService;

    /**
     * The admin and user that are currently being viewed.
     */
    protected $currentRouteName = null;

    /**
     * The admin and user that are currently being viewed.
     */
    protected $admin = null;
    protected $user = null;

    /**
     * The admin and user that are currently logged in.
     */
    protected $loggedInAdmin = null;
    protected $loggedInUser= null;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;

        $this->currentRouteName = Route::currentRouteName();
        view()->share('currentRouteName', $this->currentRouteName);
    }

    /**
     * Sets the following controller class variables and view variables of the same name.
     *      loggedInAdmin - The admin that is currently logged in.
     *      admin         - The admin that is currently being viewed.
     *
     * @return void
     */
    protected function setCurrentAdminAndUser()
    {
        $params = Route::current()->parameters();

        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser = loggedInUser();

        $this->admin = null;
        $this->user = null;

        // update the admin that is currently being viewed
        if (!empty($params['admin']->id)) {

            // check for url parameter name "admin"
            Cookie::queue('current_admin_id', $params['admin']->id, 60);

            if (!empty($params['admin']->id)) {
                $this->admin = Admin::find($params['admin']->id);
            }

        } else {

            // check cookie named "current_admin_id"
            $adminId = Cookie::get('current_admin_id', null);

            if (!empty($adminId)) {
                $this->admin = Admin::find($adminId);
            }

            if (empty($this->admin)) {
                Cookie::queue('current_admin_id', null, 60);
            }
        }

        // update the user that is currently being viewed
        if (!empty($params['user']->id)) {

            // check for url parameter name "user"
            Cookie::queue('current_user_id', $params['user']->id, 60);

            if (!empty($params['user']->id)) {
                $this->user = User::find($params['user']->id);
            }

        } else {

            // check cookie named "current_user_id"
            $userId = Cookie::get('current_user_id', null);

            if (!empty($userId)) {
                $this->user = Admin::find($userId);
            }

            if (empty($this->user)) {
                Cookie::queue('current_user_id', null, 60);
            }
        }

        view()->share('loggedInAdmin', $this->loggedInAdmin);
        view()->share('loggedInUser', $this->loggedInUser);

        view()->share('admin', $this->admin);
        view()->share('user', $this->user);
    }
}
