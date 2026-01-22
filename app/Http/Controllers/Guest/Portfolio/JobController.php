<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Award;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\Skill;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends BaseGuestController
{
    /**
     * Display a listing of jobs.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $owner = $admin;

        $perPage = $request->query('per_page', $this->perPage());

        $jobs = Job::where('owner_id', $owner->id)
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.job.index'), compact('owner', 'jobs'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified job.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        $owner = $admin;

        if (!$job = Job::where('owner_id', $owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.job.show'), compact('owner', 'job'));
    }
    /**
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function resume(Admin $admin, Request $request): View
    {
        $owner = $admin;

        $jobs = Job::where('owner_id', $owner->id)
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        $educations = Education::where('owner_id', $owner->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('graduation_year', 'desc')->orderBy('graduation_month', 'desc')
            ->orderBy('enrollment_year', 'desc')->orderBy('enrollment_month', 'desc')
            ->get();

        $certificates = Certificate::where('owner_id', $owner->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('received', 'desc')
            ->get();

        $awards = Award::where('owner_id', $owner->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('year', 'asc')
            ->get();

        $skills = Skill::where('owner_id', $owner->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->get();

        return view(
            Job::resumeTemplate(),
            compact('owner', 'jobs', 'educations', 'admin', 'certificates', 'awards', 'skills')
        );
    }
}
