@php
    use App\Models\Portfolio\Job;
    use App\Models\Portfolio\JobCoworker;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobCoworker = $jobCoworker ?? null;

    $title    = 'Edit ' . getResourcePageTitle($jobCoworker);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                    'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',                         'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                               'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                                    'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Job Coworkers',                           'href' => route('admin.portfolio.job-coworker.index') ],
        [ 'name' => getResourcePageTitle($jobCoworker, false), 'href' => route('admin.portfolio.job-coworker.show', $jobCoworker) ],
        [ 'name' => 'Edit']
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.job-coworker.index') ])->render(),
    ];

    // get the options for the job select list
    $jobListOptions = new Job()->filteredListOptions($admin, $job->owner_id ?? null, 'company');
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($jobListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no jobs to attach a coworker to.</p>
        </div>

    @else

        <form action="{{ route('admin.portfolio.job-coworker.update', array_merge([$jobCoworker], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-coworker.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $jobCoworker->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $jobCoworker->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? $jobCoworker->owner_id,
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-owner' ]
                        ])
                    @else
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $jobCoworker->owner_id
                        ])
                    @endif

                    @include('admin.components.form-select-horizontal', [
                        'name'      => 'job_id',
                        'label'     => 'job',
                        'value'     => old('job_id') ?? $jobCoworker->job_id,
                        'required'  => true,
                        'list'      => $jobListOptions,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? $jobCoworker->name,
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ]
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'title',
                        'value'     => old('title') ?? $jobCoworker->title,
                        'maxlength' => 100,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ]
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'      => 'level',
                        'value'     => old('level') ?? $jobCoworker->level,
                        'required'  => true,
                        'list'      => JobCoworker::levelListOptions([], true),
                        'message'   => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-input-horizontal', [
                        'type'      => 'tel',
                        'name'      => 'work_phone',
                        'label'     => 'work phone',
                        'value'     => old('work_phone') ?? $jobCoworker->work_phone,
                        'maxlength' => 50,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-phone' ]
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'      => 'tel',
                        'name'      => 'personal_phone',
                        'label'     => 'personal phone',
                        'value'     => old('personal_phone') ?? $jobCoworker->personal_phone,
                        'maxlength' => 50,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-phone' ]
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'work_email',
                        'label'     => 'work email',
                        'value'     => old('work_email') ?? $jobCoworker->work_email,
                        'maxlength' => 20,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-email' ]
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'personal_email',
                        'label'     => 'personal email',
                        'value'     => old('personal_email') ?? $jobCoworker->personal_email,
                        'maxlength' => 20,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-email' ]
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link' => old('link') ?? $jobCoworker->link,
                        'name' => old('link_name') ?? $jobCoworker->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $jobCoworker->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ]
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? $jobCoworker->disclaimer,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-disclaimer' ]
                    ])

                    @include('admin.components.show-row-images', [
                        'resource' => $jobCoworker,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'id'      => 'notes',
                        'value'   => old('notes') ?? $jobCoworker->notes,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ]
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $jobCoworker->is_public,
                        'is_readonly' => old('is_readonly') ?? $jobCoworker->is_readonly,
                        'is_root'     => old('is_root')     ?? $jobCoworker->root,
                        'is_disabled' => old('is_disabled') ?? $jobCoworker->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $jobCoworker->is_demo,
                        'sequence'    => old('sequence')    ?? $jobCoworker->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-coworker.index')
            ])

        </form>

    @endif

@endsection
