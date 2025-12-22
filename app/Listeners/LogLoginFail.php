<?php

namespace App\Listeners;

use App\Models\System\Admin;
use App\Models\System\LoginAttemptsAdmin;
use App\Models\System\LoginAttemptsUser;
use App\Models\System\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogLoginFail
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
    public function handle(Failed $event): void
    {
        if (config('app.record_logins')) {

            $username = $event->credentials['username'];
            $ipAddress = Request::ip();

            if ($event->guard == 'admin') {

                Log::info('Admin login attempt failed for ' . $username . ' from ' . $ipAddress);

                LoginAttemptsAdmin::insert([
                    'admin_id'   => null,
                    'username'   => $username,
                    'ip_address' => $ipAddress,
                    'action'     => 'login',
                    'success'    => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } elseif ($event->guard == 'user') {

                Log::info('User login attempt failed for ' . $username . ' from ' . $ipAddress);

                LoginAttemptsUser::insert([
                    'user_id' => null,
                    'username' => $username,
                    'ip_address' => $ipAddress,
                    'action' => 'login',
                    'success' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

        }
    }
}
