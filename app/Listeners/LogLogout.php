<?php

namespace App\Listeners;

use App\Models\System\Admin;
use App\Models\System\LoginAttemptsAdmin;
use App\Models\System\LoginAttemptsUser;
use App\Models\System\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogLogout
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
    public function handle(Logout $event): void
    {
        if (config('app.record_logins')) {

            $ipAddress = Request::ip();

            if ($event->guard == 'admin') {

                $admin = $event->user;

                Log::info('Admin ' . ($admin->username ?? '?') . ' (' . ($admin->id ?? '??') . ') logged out from ' . $ipAddress);

                LoginAttemptsAdmin::insert([
                    'admin_id'   => $admin->id ?? null,
                    'username'   => $admin->username ?? '?',
                    'ip_address' => $ipAddress,
                    'action'     => 'logout',
                    'success'    => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } elseif ($event->guard == 'user') {

                $user = $event->user;

                Log::info('User ' . ($user->username ?? '?') . ' (' . ($user->id ?? '?') . ') logged out from ' . $ipAddress);

                LoginAttemptsUser::insert([
                    'user_id'    => $user->id->id ?? null,
                    'username'   => $user->username->id ?? '?',
                    'ip_address' => $ipAddress,
                    'action'     => 'logout',
                    'success'    => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

        }
    }
}
