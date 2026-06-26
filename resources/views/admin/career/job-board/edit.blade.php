@php
    use App\Models\Career\Recruiter;
    use App\Models\Career\RecruiterIndustry;
    use App\Models\System\Country;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $jobBoard      = $jobBoard ?? null;

    $title    = 'Edit ' . getResourcePageTitle($jobBoard);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                      'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                               'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',                           'href' => route('admin.career.job-board.index') ],
        [ 'name' => getResourcePageTitle($jobBoard, false), 'href' => route('admin.career.job-board.show', $jobBoard) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.job-board.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.job-board.update', array_merge([$jobBoard], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.job-board.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $jobBoard->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $jobBoard->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? $jobBoard->name,
                        'required'  => true,
                        'maxlength' => 100,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-checkbox-horizontal', [
                        'name'            => 'primary',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => old('primary') ?? $jobBoard->primary,
                        'message'         => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'summary',
                        'value'     => old('summary') ?? $jobBoard->summary,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'style'     => [ 'max-width: 40rem !important' ]
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'    => 'number',
                        'name'    => 'founded',
                        'value'   => old('founded') ?? $jobBoard->founded,
                        'min'     => 1800,
                        'max'     => date("Y"),
                        'message' => $message ?? '',
                        'style'   => [ 'width: 6rem' ]
                    ])


                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'recruiter_industry_id',
                        'label'    => 'industry',
                        'value'    => old('recruiter_industry_id') ?? $jobBoard->recruiter_industry_id,
                        'list'     => new RecruiterIndustry()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'recruiter_id',
                        'label'    => 'recruiting firm',
                        'value'    => old('recruiter_id') ?? $jobBoard->recruiter_id,
                        'list'     => new Recruiter()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-job-board-types-horizontal', [
                        'free'      => old('free')      ?? $jobBoard->free,
                        'premium'   => old('premium')   ?? $jobBoard->premium,
                        'staffing'  => old('staffing')  ?? $jobBoard->staffing,
                        'freelance' => old('freelance') ?? $jobBoard->freelance,
                        'message'   => $message         ?? '',
                    ])

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">coverage areas</label>
                        </div>
                        <div class="field-body">
                            <div class="field" style="flex-grow: 0;">

                                @include('admin.components.form-coverage-areas', [
                                    'resource' => $jobBoard
                                ])

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'name'               => 'linkedin_url',
                        'label'              => 'linkedin url',
                        'link'               => old('linkedin_url') ?? $jobBoard->linkedin_url,
                        'include_name_field' => false,
                        'message'            => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'               => 'jobs_url',
                        'label'              => 'jobs url',
                        'link'               => old('jobs_url') ?? $jobBoard->jobs_url,
                        'include_name_field' => false,
                        'message'            => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-location-horizontal', [
                        'street'     => old('street') ?? $jobBoard->street,
                        'street2'    => old('street2') ?? $jobBoard->street2,
                        'city'       => old('city') ?? $jobBoard->city,
                        'state_id'   => old('state_id') ?? $jobBoard->state_id,
                        'states'     => new State()->listOptions([], 'id', 'name', true),
                        'zip'        => old('zip') ?? $jobBoard->zip,
                        'country_id' => old('country_id') ?? $jobBoard->country_id,
                        'countries'  => new Country()->listOptions([], 'id', 'name', true),
                        'message'    => $message ?? '',
                    ])

                    @include('admin.components.form-coordinates-horizontal', [
                        'latitude'  => old('latitude') ?? $jobBoard->latitude,
                        'longitude' => old('longitude') ?? $jobBoard->longitude,
                        'message'   => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-phone-horizontal', [
                        'phone' => old('phone') ?? $jobBoard->phone,
                        'label' => old('phone_label') ?? $jobBoard->phone_label,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-phone-horizontal', [
                        'phone'   => old('alt_phone') ?? $jobBoard->alt_phone,
                        'label'   => old('alt_phone_label') ?? $jobBoard->alt_phone_label,
                        'alt'     => true,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-email-horizontal', [
                        'email'   => old('email') ?? $jobBoard->email,
                        'label'   => old('email_label') ?? $jobBoard->email_label,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-email-horizontal', [
                        'email'   => old('alt_email') ?? $jobBoard->alt_email,
                        'label'   => old('alt_email_table') ?? $jobBoard->alt_email_label,
                        'alt'     => true,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link'    => old('link') ?? $jobBoard->link,
                        'name'    => old('link_name') ?? $jobBoard->link_name,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $jobBoard->description,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.show-row-images', [
                        'resource' => $jobBoard,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $jobBoard->notes,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $jobBoard->is_public,
                        'is_readonly' => old('is_readonly') ?? $jobBoard->is_readonly,
                        'is_root'     => old('is_root')     ?? $jobBoard->root,
                        'is_disabled' => old('is_disabled') ?? $jobBoard->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $jobBoard->is_demo,
                        'sequence'    => old('sequence')    ?? $jobBoard->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.job-board.index')
            ])

        </form>

    </div>

@endsection
