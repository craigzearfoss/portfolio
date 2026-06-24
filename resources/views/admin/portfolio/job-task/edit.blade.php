@php
    use App\Models\Portfolio\Job;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobTask     = $jobTask ?? null;

    $title    = 'Edit ' . getResourcePageTitle($jobTask);
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',                                'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',                     'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                           'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                                'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Job Tasks',                           'href' => route('admin.portfolio.job-task.index') ],
        [ 'name' => getResourcePageTitle($jobTask, false), 'href' => route('admin.portfolio.job-task.show', $jobTask) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.job-task.index') ])->render(),
    ];

    // get the options for the job select list
    $jobListOptions = new Job()->filteredListOptions($admin, $job->owner_id ?? null, 'company');
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($jobListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no jobs to attach a task to.</p>
        </div>

    @else

        <form action="{{ route('admin.portfolio.job-task.update', array_merge([$jobTask], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-task.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $jobTask->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $jobTask->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    <?php /* note that you CANNOT change the owner of a job task */ ?>
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $jobTask->owner_id
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'      => 'job_id',
                        'label'     => 'job',
                        'value'     => old('job_id') ?? $jobTask->job_id,
                        'required'  => true,
                        'list'      => $jobListOptions,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'summary',
                        'value'     => old('summary') ?? $jobTask->summary,
                        'required'  => true,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'style'     => [ 'max-width: 40rem !important' ]
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link' => old('link') ?? $jobTask->link,
                        'name' => old('link_name') ?? $jobTask->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $jobTask->description,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-input-horizontal', [
                        'name'        => 'disclaimer',
                        'value'       => old('disclaimer') ?? $jobTask->disclaimer,
                        'maxlength'   => 500,
                        'message'     => $message ?? '',
                    ])

                    @include('admin.components.show-row-images', [
                        'resource' => $jobTask,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $jobTask->notes,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $jobTask->is_public,
                        'is_readonly' => old('is_readonly') ?? $jobTask->is_readonly,
                        'is_root'     => old('is_root')     ?? $jobTask->root,
                        'is_disabled' => old('is_disabled') ?? $jobTask->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $jobTask->is_demo,
                        'sequence'    => old('sequence')    ?? $jobTask->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-task.index')
            ])

        </form>

    @endif

@endsection
