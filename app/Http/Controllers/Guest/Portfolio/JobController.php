<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends BaseGuestController
{
    public function resume(Request $request): View
    {
        $jobs = Job::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('start_year', 'desc')->orderBy('start_month', 'desc')->get();

        return view(Job::resumeTemplate(), compact('jobs'));
    }
}
