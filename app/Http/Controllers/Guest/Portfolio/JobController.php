<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function show(Request $request): View
    {
        $jobs = Job::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('start_year', 'desc')->orderBy('start_month', 'desc')->get();

        return view('guest.portfolio.job.show', compact('jobs'));
    }
}
