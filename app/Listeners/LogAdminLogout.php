<?php

namespace App\Listeners;

use App\Models\Admin as Admin;
use App\Models\System\LoginAttemptsAdmin;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LogAdminLogout
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

            $admin = $event->user;
            $ipAddress = Request::ip();

            Log::info('Admin ' . $admin->username . ' (' . $admin->id . ') logged out from ' . $ipAddress);

            LoginAttemptsAdmin::insert([
                'admin_id'   => $admin->id,
                'username'   => $admin->username,
                'ip_address' => $ipAddress,
                'action'     => 'logout',
                'success'    => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
