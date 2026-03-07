<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait ModelPermissionsTrait
{
    /**
     * Throws a validation exception if the site is in demo mode and the user is not an admin with root permissions.
     *
     * @return void
     */
    public function checkDemoMode(): void
    {
        if (isDemo() && !isRootAdmin()) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'You cannot update data when the site is in demo mode.'
            ]);
        }
    }

    /**
     * Throws a validation exception if the user does not own the resource and is not an admin with root permissions.
     *
     * @return void
     */
    public function checkOwner(): void
    {
        if (!empty($this->owner_id)) {

            if (!isRootAdmin() && (Auth::guard('admin')->user()->id != $this->owner_id)) {
                throw ValidationException::withMessages([
                    'GLOBAL' => 'You are not authorized to update this resource.'
                ]);
            }

        } else {

                $this->merge(['owner_id' => Auth::guard('admin')->user()->id]);
        }
    }
}
