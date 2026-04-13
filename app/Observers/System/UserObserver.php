<?php

namespace App\Observers\System;

use App\Models\System\User;

class UserObserver
{
    public function saved(User $user): void {

        // set the user_id field to the id of the user
        $user['user_id'] = $user['id'];
        $user->saveQuietly();
    }
}
