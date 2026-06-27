@php
    use App\Models\Dictionary\Category;
    use App\Models\Portfolio\Job;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobSkill    = $jobSkill ?? null;

    $title    = 'Edit ' . getResourcePageTitle($jobSkill);
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',                                 'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',                      'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                            'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',                                 'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Job Skills',                           'href' => route('admin.portfolio.job-skill.index') ],
        [ 'name' => getResourcePageTitle($jobSkill, false), 'href' => route('admin.portfolio.job-skill.show', $jobSkill) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.job-skill.index') ])->render(),
    ];

    // get the options for the job select list
    $jobListOptions = new Job()->filteredListOptions($admin, $job->owner_id ?? null, 'company');
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($jobListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no jobs to attach a skill to.</p>
        </div>

    @else

        <form action="{{ route('admin.portfolio.job-skill.update', array_merge([$jobSkill], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-skill.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $jobSkill->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $jobSkill->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? $jobSkill->owner_id,
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-owner' ]
                        ])
                    @else
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $jobSkill->owner_id
                        ])
                    @endif

                    @include('admin.components.form-select-horizontal', [
                        'name'      => 'job_id',
                        'label'     => 'job',
                        'value'     => old('job_id') ?? $jobSkill->job_id,
                        'required'  => true,
                        'list'      => $jobListOptions,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? $jobSkill->name,
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ]
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'      => 'dictionary_category_id',
                        'label'     => 'category',
                        'value'     => old('job_id') ?? $jobSkill->dictionary_category_id,
                        'required'  => true,
                        'list'      => new Category()->listOptions([], 'id', 'name', true),
                        'message'   => $message ?? '',
                    ])

                    <div style="display: none;">
                    @include('admin.components.form-input-with-icon', [
                        'type'      => 'hidden',
                        'name'      => 'dictionary_term_id',
                        'label'     => 'dictionary term',
                        'value'     => old('dictionary_term_id') ?? $jobSkill->dictionary_term_id,
                        'message'   => $message ?? '',
                    ])
                    </div>

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'summary',
                        'value'     => old('summary') ?? $jobSkill->summary,
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 5,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-summary' ],
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link'    => old('link') ?? $jobSkill->link,
                        'name'    => old('link_name') ?? $jobSkill->link_name,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $jobSkill->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ]
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? $jobSkill->disclaimer,
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 3,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-disclaimer' ],
                    ])

                    @include('admin.components.show-row-images', [
                        'resource' => $jobSkill,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $jobSkill->notes,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-notes' ]
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $jobSkill->is_public,
                        'is_readonly' => old('is_readonly') ?? $jobSkill->is_readonly,
                        'is_root'     => old('is_root')     ?? $jobSkill->root,
                        'is_disabled' => old('is_disabled') ?? $jobSkill->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $jobSkill->is_demo,
                        'sequence'    => old('sequence')    ?? $jobSkill->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-skill.index')
            ])

        </form>

    @endif

@endsection
