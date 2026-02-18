<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Route;

class BaseAdminController extends BaseController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::ADMIN);
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

        if (($routeParts[0] == 'admin') && count($routeParts) > 2) {
            if ($resource = new Resource()->getResourceByName($routeParts[1], $routeParts[2])) {
                $resourceType = $resource['database_name'] . '.' . $resource['name'];
            }
        }

        return $resourceType;
    }
}
