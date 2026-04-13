<?php

namespace App\Observers\System;

use App\Models\System\Admin;

class AdminObserver
{
    public function saved(Admin $admin): void {

        // set the owner_id field to the id of the admin
        $admin['owner_id'] = $admin['id'];
        $admin->saveQuietly();
    }
}
