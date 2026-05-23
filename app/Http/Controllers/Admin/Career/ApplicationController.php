<?php

namespace App\Http\Controllers\Admin\Career;

use App\Exports\Career\ApplicationsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreApplicationsRequest;
use App\Http\Requests\Career\UpdateApplicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\ApplicationAntiSkill;
use App\Models\Career\ApplicationSkill;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use App\Models\Portfolio\AntiSkill;
use App\Models\Portfolio\JobSkill;
use App\Models\Portfolio\Skill;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class ApplicationController extends BaseAdminController
{
    /**
     * Display a listing of applications.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Application::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $applications = new Application()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Application::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->orderBy('post_date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)->appends(request()->except('page'));

        $resume = $request->input('resume_id')
            ? Resume::query()->findOrFail($request->input('resume_id'))
            : null;

        $pageTitle = 'Applications';

        return view('admin.career.application.index', compact('applications', 'resume', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new application.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(Application::class, $this->admin);

        $errorMessages = [];
        $urlParams = [];

        if ($companyId = $request->query('company_id')) {
            $urlParams['company_id'] = $companyId;
            if (!Company::query()->find($companyId)) {
                $errorMessages[] = "Company `$companyId` not found.";
            }
        }

        if ($resumeId = $request->query('resume_id')) {
            $urlParams['resume_id'] = $resumeId;
            if (!Resume::query()->find($resumeId)) {
                $errorMessages[] = "Resume `$resumeId` not found.";
            }
        }

        if ($coverLetterId = $request->query('cover_letter_id')) {
            $urlParams['cover_letter_id'] = $coverLetterId;
            if (!CoverLetter::query()->find($coverLetterId)) {
                $errorMessages[] = "Cover letter `$coverLetterId` not found.";
            }
        }

        if (!empty($errorMessages)) {
            return view('admin.career.application.create', $urlParams)
                ->withErrors(['GLOBAL' => implode('<br>', $errorMessages)]);
        } else {
            return view(
                'admin.career.application.create',
                compact('companyId', 'resumeId', 'coverLetterId', 'urlParams')
            );
        }
    }

    /**
     * Store a newly created application in storage.
     *
     * @param StoreApplicationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreApplicationsRequest $request): RedirectResponse
    {
        createGate(Application::class, $this->admin);

        $application = Application::query()->create($request->validated());

        // create a cover letter for the application
        $coverLetterData = [
            'owner_id'       => $application->owner_id,
            'application_id' => $application->id,
            'name'           => CoverLetter::getName($application->id),
        ];
        $coverLetterData['slug'] = uniqueSlug($coverLetterData['name'], 'career_db.cover_letters', $application->owner_id);

        CoverLetter::query()->insert($coverLetterData);

        // add the portfolio.job_skills found in the description to the application skills
        if (!empty($application['description'])) {

            foreach (Application::parseSkills($application) as $skill) {
                $applicationSkill = new ApplicationSkill();
                $applicationSkill['owner_id']               = $application['owner_id'];
                $applicationSkill['application_id']         = $application['id'];
                $applicationSkill['name']                   = $skill['name'];
                $applicationSkill['level']                  = -1;
                $applicationSkill['dictionary_category_id'] = null;
                $applicationSkill['dictionary_term_id']     = null;
                $applicationSkill->save();
            }

            foreach (Application::parseAntiSkills($application) as $antiSkill) {
                $applicationAntiSkill = new ApplicationAntiSkill();
                $applicationAntiSkill['owner_id']               = $application['owner_id'];
                $applicationAntiSkill['application_id']         = $application['id'];
                $applicationAntiSkill['name']                   = $antiSkill['name'];
                $applicationAntiSkill['level']                  = -1;
                $applicationAntiSkill['dictionary_category_id'] = null;
                $applicationAntiSkill['dictionary_term_id']     = null;
                $applicationAntiSkill->save();
            }
        }

        return redirect()->route('admin.career.application.show', $application)
            ->with('success', 'Application successfully added.');
    }

    /**
     * Display the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function show(Application $application): View
    {
        readGate($application, $this->admin);

        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

        $skills     = Skill::ownerSkills($application['owner_id'])->pluck('name')->toArray();
        $antiSkills = AntiSkill::ownerSkills($application['owner_id'])->pluck('name')->toArray();

        list($matchedSkills, $parsedDescription)     = Skill::parseSkills($skills, $application->description ?? '');
        list($matchedAntiSkills, $parsedDescription) = AntiSkill::parseSkills($antiSkills, $parsedDescription);

        list($prev, $next) = $application->prevAndNextPages(
            $application['id'],
            'admin.career.application.show',
            $this->owner ?? null,
            [ 'post_date', 'asc' ]
        );

        return view('admin.career.application.show',
            compact('application', 'skills', 'antiSkills', 'matchedSkills', 'matchedAntiSkills',
            'parsedDescription', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function edit(Application $application): View
    {
        updateGate($application, $this->admin);

        return view('admin.career.application.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     *
     * @param UpdateApplicationsRequest $request
     * @param Application $application
     * @return RedirectResponse
     */
    public function update(UpdateApplicationsRequest $request,
                           Application               $application): RedirectResponse
    {
        updateGate($application, $this->admin);

        $application->update($request->validated());

        // if the description has changed then update the application skills
        if ($request->input('description_changed') ?? false) {

            $skillUpdateOK = true;
            if (!new ApplicationSkill()->addSkills($application, Application::parseSkills($application))) {
                $skillUpdateOK = false;
            }

            if (!new ApplicationAntiSkill()->addSkills($application, Application::parseAntiSkills($application))) {
                $skillUpdateOK = false;
            }

            if (!$skillUpdateOK) {
                if ($referer = $request->input('referer')) {
                    return redirect($referer)->withErrors(['GLOBAL' => 'Application updated but there was a problem updating the skills.']);
                } else {
                    return redirect()->route('admin.career.application.show', $application)
                        ->withErrors(['GLOBAL' => 'Application updated but there was a problem updating the skills.']);
                }
            }
        }

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', 'Application successfully updated.');
        } else {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Application successfully updated.');
        }
    }

    /**
     * Remove the specified application from storage.
     *
     * @param Application $application
     * @return RedirectResponse
     */
    public function destroy(Application $application): RedirectResponse
    {
        deleteGate($application, $this->admin);

        $application->delete();

        return redirect(referer('admin.portfolio.application.index'))
            ->with('success', 'Application deleted successfully.');
    }

    /**
     * Create a cover letter.
     *
     * @param Application $application
     * @return Application
     */
    protected function createCoverLetter(Application $application): Application
    {
        updateGate($application, $this->admin);

        $name = CoverLetter::getName($application->id);
        $slug = uniqueSlug($name, 'career_db.cover_letters', $application->id);

        if (empty($application->coverLetter)) {
            CoverLetter::query()->insert([
                'owner_id'       => $application['owner_id'],
                'application_id' => $application->id,
                'name'           => $name,
                'slug'           => $slug,
            ]);
            $application = Application::query()->find($application->id);
        }

        return $application;
    }


    /**
     * Show the form for attaching a resume to a specified application.
     *
     * @param Application $application
     * @return View
     */
    public function attachResume(Application $application): View
    {
        updateGate($application, $this->admin);

        return view('admin.career.application.resume.attach', compact('application'));
    }

    /**
     * Attach a resume to an application.
     *
     * @param Application $application
     * @param Request $request
     * @return RedirectResponse
     */
    public function attachResumeStore(Application $application, Request $request): RedirectResponse
    {
        updateGate($application, $this->admin);

        $applicationResume = $request->input('application_resume');

        if (!$resumeId = explode('|', $applicationResume)[0]) {
            return redirect()->back()->withErrors(['GLOBAL' => 'No resume id specified.']);
        }

        if (!$fileType = explode('|', $applicationResume)[1] ?? null) {
            return redirect()->back()->withErrors(['GLOBAL' => 'No file specified.']);
        } elseif (!in_array($fileType, [ 'doc', 'pdf' ])) {
            return redirect()->back()->withErrors(['GLOBAL' => 'Invalid file type `' . $fileType . '`.']);
        }

        if (!$resume = Resume::query()->find($resumeId)) {
            return redirect()->back()->withErrors(['GLOBAL' => 'Resume `' . $resumeId . '` not found.']);
        } elseif ($resume['owner_id'] != $application['owner_id']) {
            return redirect()->back()->withErrors(['GLOBAL' => 'Resume `' . $resumeId . '` does not belong to this application..']);
        }

        $column = match ($fileType) {
            'doc' => 'doc_filepath',
            'pdf' => 'pdf_filepath',
            default => 'other_filepath',
        };

        if (empty($resume->{$column})) {
            return redirect()->back()->withErrors(['GLOBAL' => strtoupper($fileType) . ' file not found for resume `' . $resumeId . '`.']);
        }

        // copy the resume source file
        $relativeSrcPath = DIRECTORY_SEPARATOR . $resume->{$column};
        $absoluteSrcPath = public_path() . DIRECTORY_SEPARATOR . $relativeSrcPath;
        $resumeFileName = substr(strrchr($relativeSrcPath, DIRECTORY_SEPARATOR), 1);
        if (!file_exists($absoluteSrcPath)) {
            return redirect()->back()->withErrors(['GLOBAL' => 'Resume `' . $resumeId . '` file not found.']);
        }

        // determine the resume destination file
        $relativeDestPath = 'images' . DIRECTORY_SEPARATOR . 'portfolio' . DIRECTORY_SEPARATOR . 'career' .
            DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . $application['id'] . DIRECTORY_SEPARATOR . $resumeFileName;
        $absoluteDestPath = public_path() . DIRECTORY_SEPARATOR . $relativeDestPath;
        $absoluteDestDirectory = strrchr($absoluteDestPath, DIRECTORY_SEPARATOR, true);

        if (!File::exists($absoluteDestDirectory)) {
            File::makeDirectory($absoluteDestDirectory, 755, true);
        }

        File::copy($absoluteSrcPath,$absoluteDestPath);
        if (!file_exists($absoluteDestPath)) {
            return redirect()->back()->withErrors(['GLOBAL' => 'Resume `' . $resumeId . '` file could not be copied.']);
        }

        $application['resume_id']       = $resumeId;
        $application['resume_filepath'] = $relativeDestPath;
        $application['resume_datetime'] = date("Y-m-d H:i:s");
        $application->save();

        return redirect()->route('admin.career.application.show', $application)
            ->with('success', 'Resume has been attached to the application.');
    }

    /**
     * Add a skill to an application.
     *
     * @param Application $application
     * @return JsonResponse
     */
    public function addSkill(Application $application): JsonResponse
    {
        $respArray = [
            'success' => 0,
        ];

        if (!$skillName = request()->input('name')) {
            $respArray['message'] = 'No skill name specified.';
            return response()->json($respArray);
        }

        // @TODO: Need to add the dictionary_term_id and dictionary_category_id
        if (new ApplicationSkill()->addSkill($application, request()->all())) {
            $respArray['success'] = 1;
            $respArray['message'] = $skillName . ' skill added successfully.';
        }

        return response()->json($respArray);
    }

    /**
     * Remove a skill from an application.
     *
     * @param Application $application
     * @param ApplicationSkill $applicationSkill
     * @return JsonResponse
     */
    public function removeSkill(Application $application, ApplicationSkill $applicationSkill): JsonResponse
    {
        $respArray = [
            'success' => 0,
        ];

        if (!canUpdate($application, $this->admin)) {
            $respArray['message'] = 'Not authorized for owner ' . $this->admin['id'] . ' to delete application skill ' .
                $applicationSkill['id'] . ' (' . $applicationSkill['name'] . ').';
            return response()->json($respArray);
        }

        // remove the skill from the application
        if (new ApplicationSkill()->removeSkill($applicationSkill['id'])) {
            $respArray['success'] = 1;
            $respArray['message'] = $applicationSkill['name'] . ' skill removed successfully.';
        } else {
            $respArray['message'] = $applicationSkill['name'] . ' skill could not be removed.';
        }

        return response()->json($respArray);
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Application::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'applications_' . date("Y-m-d-His") . '.xlsx'
            : 'applications.xlsx';

        return Excel::download(new ApplicationsExport(), $filename);
    }

    public function analyze(): View
    {
        if ($this->isRootAdmin) {
            if (!$owner_id = request()->input('owner_id')) {
                $owner_id = $this->owner['id'] ?? $this->admin['id'] ?? null;
            }
        } else {
            $owner_id = $this->admin['id'] ?? null;
        }
        $isPost            = false;
        $description       = '';

        $skills     = Skill::ownerSkills($owner_id)->pluck('name')->toArray();
        $antiSkills = AntiSkill::ownerSkills($owner_id)->pluck('name')->toArray();

        $selectedSkills = $skills;
        $selectedAntiSkills = $antiSkills;

        return view('admin.career.application.analyze',
            compact('owner_id', 'description', 'skills', 'antiSkills',
                'selectedSkills', 'selectedAntiSkills', 'isPost'));
    }

    public function analyzePost(Request $request): View|RedirectResponse
    {
        if ($this->isRootAdmin) {
            if (!$owner_id = $request->input('owner_id')) {
                $owner_id = $this->owner['id'] ?? $this->admin['id'] ?? null;
            }
        } else {
            $owner_id = $this->admin['id'];
        }
        $isPost = true;
        if (!$description = $request->input('description')) {
            $description = '';
        }

        $skills     = Skill::ownerSkills($owner_id)->pluck('name')->toArray();
        $antiSkills = AntiSkill::ownerSkills($owner_id)->pluck('name')->toArray();

        if (!$selectedSkills = $request->input('skill')) {
            $selectedSkills = [];
        }
        if (!$selectedAntiSkills = $request->input('anti_skill')) {
            $selectedAntiSkills = [];
        }

        if (empty($description)) {
            return redirect()->back()->with('error', 'No job description specified.');
        } elseif (empty($selectedSkills) || empty($selectedAntiSkills)) {
            return redirect()->back()->with('error', 'No skills or anti-skills specified.');
        }

        list($matchedSkills, $parsedDescription)     = Skill::parseSkills($selectedSkills, $description);
        list($matchedAntiSkills, $parsedDescription) = AntiSkill::parseSkills($selectedAntiSkills, $parsedDescription);

        return view('admin.career.application.analyze',
            compact('owner_id', 'description', 'parsedDescription', 'skills', 'antiSkills',
                'selectedSkills', 'selectedAntiSkills', 'matchedSkills', 'matchedAntiSkills', 'isPost'));
    }
}
