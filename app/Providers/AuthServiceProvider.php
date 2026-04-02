<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];
    /**
     * Register any application authentication / authorization services.
     */
    public function boot(): void
    {
        // @TODO: Need to get the gates working
        $this->registerPolicies();

        // define gate for admin editing/updating a resource
        Gate::allows('update-resource', function ($admin, $resourceObj): bool
        {
            if ($admin->is_root) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin->id)) {
                return true;
            } else {
                return false;
            }
        });

        // define gate for an admin deleting a resource
        Gate::define('delete-resource', function ($resourceObj, Admin $admin): bool
        {
            if ($admin['is_root']) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin->id)) {
                return true;
            } else {
                return false;
            }
        });
    }
}
