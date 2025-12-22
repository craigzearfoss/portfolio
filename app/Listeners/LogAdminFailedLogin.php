<?php

namespace App\Listeners;

use App\Models\Admin as Admin;
use App\Models\System\LoginAttemptsAdmin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogAdminFailedLogin
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
        }
    }
}
