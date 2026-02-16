<?php

namespace App\Services;

use App\Models\Portfolio\Award;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\Skill;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ResumeService {

    public Admin|Owner|null $admin = null;

    public array|Collection $awards = [];

    public array|Collection $certificates = [];

    public array|Collection $educations = [];

    public array|Collection $jobs = [];

    public array|Collection $skills = [];

    protected string|null $template = null;

    /**
     * @param Admin $admin
     * @param string|null $templateName
     */
    public function __construct(Admin $admin, string|null $templateName = null)
    {
        $this->template = Job::resumeTemplate($templateName);

        $this->loadData($admin);
    }

    /**
     * @param Admin $admin
     * @return void
     */
    protected function loadData(Admin $admin)
    {
        $this->admin = $admin;

        $this->awards = new Award()->where('owner_id', $this->admin->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('year')
            ->get();

        $this->certificates = new Certificate()->where('owner_id', $this->admin->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('received', 'desc')
            ->get();

        $this->educations = new Education()->where('owner_id', $this->admin->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('graduation_year', 'desc')->orderBy('graduation_month', 'desc')
            ->orderBy('enrollment_year', 'desc')->orderBy('enrollment_month', 'desc')
            ->get();

        $this->jobs = new Job()->where('owner_id', $this->admin->id)
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        $this->skills = new Skill()->where('owner_id', $this->admin->id)
            ->where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence')
            ->get();
    }

    /**
     * Returns the resume template.
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Sets the resume template.
     *
     * @param string $templateName
     * @return bool
     */
    public function setTemplate(string $templateName): bool
    {
        $this->template = Job::resumeTemplate($templateName);

        return true;
    }

    /**
     * Returns an array of all resume data.
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            'admin'        => $this->admin,
            'awards'       => $this->awards,
            'certificates' => $this->certificates,
            'educations'   => $this->educations,
            'jobs'         => $this->jobs,
            'skills'       => $this->skills,
        ];
    }

    public function view(): View
    {
        $owner = $this->admin;
        $resumeService = $this;

        return view($this->getTemplate(), compact('owner', 'resumeService'));
    }
}
