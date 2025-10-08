<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

trait ModelPermissionsTrait
{
    /**
     * Throws a validation exception if the site is in demo mode and the user is not an admin with root permissions.
     *
     * @return void
     */
    public function checkDemoMode()
    {
        if (isDemo() && !isRootAdmin()) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'You cannot update data when the site is in demo mode.'
            ]);
        }
    }
}
