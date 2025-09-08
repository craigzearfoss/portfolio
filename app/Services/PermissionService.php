<?php

namespace App\Services;

use App\Models\Database;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_USER = 'user';
    const USER_TYPE_GUEST = 'guest';

    const USER_TYPES = [
        self::USER_TYPE_ADMIN,
        self::USER_TYPE_USER,
        self::USER_TYPE_GUEST,
    ];

    const ACTION_CREATE = 'CREATE';
    const ACTION_READ = 'READ';
    const ACTION_UPDATE = 'UPDATE';
    const ACTION_DELETE = 'DELETE';

    const VALID_ACTIONS = [
        self::ACTION_CREATE,
        self::ACTION_READ,
        self::ACTION_UPDATE,
        self::ACTION_DELETE,
    ];

    /**
     * Returns true if the user type has permission to execute the given action on the resource type.
     *
     * @param string $resourceType
     * @param string $action
     * @param string $userType
     * @return bool
     */
    public function allowResource(string $resourceType, string $action, string $userType = 'guest'): bool
    {
        if (empty($userType)) {
            $userType = $this->currentUserType();
        }

        if (in_array($userType, [self::USER_TYPE_GUEST, self::USER_TYPE_USER])) {

            // Guests and users can only read resource types.
            if ($action !== self::ACTION_READ) {
                return false;
            } else {
                return Resource::where('type', $resourceType)
                        ->where('public', 1)
                        ->where('disabled', 0)
                        ->get()->count() > 0;
            }

        } elseif ($userType === self::USER_TYPE_ADMIN) {

            if (!empty(Auth::guard('admin')->user()->root)) {
                // Root admins can view disabled resource types.
                return Resource::where('type', $resourceType)->get()->count() > 0;
            } else {
                // Non-root admins can only see resource types that are not disabled.
                return Resource::where('type', $resourceType)->where('disabled', 0)->get()->count() > 0;
            }

        } else {

            return false;

        }
    }

    /**
     * Returns an array of resource permissions for the specified user type.
     *
     * @param string|null $userType - If not specified, this defaults to the type for the current user.
     * @param bool $isRoot
     * @return array
     * @throws \Exception
     */
    public function resourcePermissions(string|null $userType, bool $isRoot = false): array
    {
        if (empty($userType)) {
            $userType = $this->currentUserType();
        }

        $permissions = [];

        foreach ((new Resource())->bySequence($userType) as $resource) {

            if (!array_key_exists($resource->db_name, $permissions)) {
                $permissions[$resource->db_name] = [
                    'CREATE' => [],
                    'READ' => [],
                    'UPDATE' => [],
                    'DELETE' => []
                ];
            }

            $permissions[$resource->db_name]['READ'][] = $resource->name;

            if ($userType ===  self::USER_TYPE_ADMIN) {
                if ($isRoot || empty($resource->root)) {
                    $permissions[$resource->db_name]['CREATE'][] = $resource->name;
                    $permissions[$resource->db_name]['UPDATE'][] = $resource->name;
                    $permissions[$resource->db_name]['DELETE'][] = $resource->name;
                }
            }
        }

        return $permissions;
    }

    /**
     * Returns the type of the current user.
     *
     * @return string
     */
    public static function currentUserType(): string
    {
        if (Auth::guard('admin')->user()) {
            return self::USER_TYPE_ADMIN;
        } elseif (Auth::guard('web')->user()) {
            return self::USER_TYPE_USER;
        } else {
            return self::USER_TYPE_GUEST;
        }
    }
}
