<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Job;
use App\Models\System\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends BaseGuestController
{
    /**
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function resume(Admin $admin, Request $request): View
    {
        $jobs = Job::where('owner_id', $admin->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        return view(Job::resumeTemplate(), compact('jobs', 'admin'));
    }
}
