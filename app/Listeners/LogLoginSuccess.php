<?php

namespace App\Listeners;

use App\Models\System\Admin;
use App\Models\System\LoginAttemptsAdmin;
use App\Models\System\LoginAttemptsUser;
use App\Models\System\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogLoginSuccess
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if (config('app.record_logins')) {

            $ipAddress = Request::ip();

            if ($event->guard == 'admin') {

                $admin = $event->user;

                Log::info('Admin ' . $admin->username . ' (' . $admin->id . ') logged in from ' . $ipAddress);

                new LoginAttemptsAdmin()->insert([
                    'admin_id'   => $admin->id,
                    'username'   => $admin->username,
                    'ip_address' => $ipAddress,
                    'action'     => 'login',
                    'success'    => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } elseif ($event->guard == 'user') {

                $user = $event->user;

                Log::info('User ' . $user->username . ' (' . $user->id . ') logged in from ' . $ipAddress);

                new LoginAttemptsUser()->insert([
                    'user_id'    => $user->id,
                    'username'   => $user->username,
                    'ip_address' => $ipAddress,
                    'action'     => 'login',
                    'success'    => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

        }
    }
}
