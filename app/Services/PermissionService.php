<?php

namespace App\Services;

use App\Enums\EnvTypes;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    const string ACTION_CREATE = 'CREATE';
    const string ACTION_READ = 'READ';
    const string ACTION_UPDATE = 'UPDATE';
    const string ACTION_DELETE = 'DELETE';

    const array VALID_ACTIONS = [
        self::ACTION_CREATE,
        self::ACTION_READ,
        self::ACTION_UPDATE,
        self::ACTION_DELETE,
    ];

    /**
     * Returns true if the ENV type has permission to execute the given action on the resource type.
     *
     * @param string $resourceType
     * @param string $action
     * @param EnvTypes $envType
     * @return bool
     */
    public function allowResource(string $resourceType, string $action, EnvTypes $envType = EnvTypes::GUEST): bool
    {
        if (empty($envType)) {
            $envType = getEnvType();
        }

        if (in_array($envType, [ EnvTypes::GUEST, EnvTypes::USER ])) {

            // Guests and users can only read resource types.
            if ($action !== self::ACTION_READ) {
                return false;
            } else {
                return new Resource()->where('type', $resourceType)
                        ->where('public', 1)
                        ->where('disabled', 0)
                        ->get()->count() > 0;
            }

        } elseif ($envType === EnvTypes::ADMIN) {

            if (!empty(Auth::guard('admin')->user()->root)) {
                // Root admins can view disabled resource types.
                return new Resource()->where('type', $resourceType)->get()->count() > 0;
            } else {
                // Non-root admins can only see resource types that are not disabled.
                return new Resource()->where('type', $resourceType)->where('disabled', 0)->get()->count() > 0;
            }

        } else {

            return false;

        }
    }

    /**
     * Returns an array of resource permissions for the specified ENV type.
     * //@TODO: Not implemented yet.
     *
     * @param Admin|null $owner
     * @param EnvTypes|null $envType - If not specified, this defaults to the type for the current user.
     * @param bool $isRoot
     * @return array
     * @throws \Exception
     */
    public function resourcePermissions(Admin|null    $owner = null,
                                        EnvTypes|null $envType = null,
                                        bool          $isRoot = false): array
    {
        if (empty($envType)) {
            $envType = getEnvType();
        }

        $permissions = [];

        foreach (!empty($owner)
                     ? AdminResource::ownerResources($owner->id, $envType)
                     : Resource::ownerResources(null, $envType)
                 as $resource) {

            if (!array_key_exists($resource->database_name, $permissions)) {
                $permissions[$resource->database_name] = [
                    'CREATE' => [],
                    'READ' => [],
                    'UPDATE' => [],
                    'DELETE' => []
                ];
            }

            $permissions[$resource->database_name]['READ'][] = $resource->name;

            if ($envType === EnvTypes::ADMIN) {
                if ($isRoot || empty($resource->root)) {
                    $permissions[$resource->database_name]['CREATE'][] = $resource->name;
                    $permissions[$resource->database_name]['UPDATE'][] = $resource->name;
                    $permissions[$resource->database_name]['DELETE'][] = $resource->name;
                }
            }
        }

        return $permissions;
    }
}
