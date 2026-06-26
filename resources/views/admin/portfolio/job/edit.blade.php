@php
    use App\Models\Portfolio\JobEmploymentType;
    use App\Models\Portfolio\JobLocationType;
    use App\Models\System\Country;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;

    $title    = $pageTitle ?? 'Edit Job: ' . $job->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                         'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                              'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                      'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                       'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Jobs',                            'href' => route('admin.portfolio.job.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($job, false), 'href' => route('admin.portfolio.job.show', $job) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.job.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.job.update', array_merge([$job], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.job.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $job->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $job->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $job->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $job->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'company',
                    'value'     => old('company') ?? $job->company,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'role',
                    'value'     => old('role') ?? $job->role,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $job->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $job->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'style'     => [ 'max-width: 40rem !important' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'month',
                    'name'      => 'start_date',
                    'label'     => 'start',
                    'value'     => old('start_date') ?? !empty($job->start_date)
                                                            ? substr($job->start_date, 0, -3)
                                                            : '',
                    'min'       => '1970-01',
                    'max'       => date("Y-m"),
                    'message'   => $message ?? '',
                    'style'     => 'width: 12rem;',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'month',
                    'name'      => 'end_date',
                    'label'     => 'end',
                    'value'     => old('end_date') ?? !empty($job->end_date)
                                                          ? substr($job->end_date, 0, -3)
                                                          : '',
                    'min'       => '1970-01',
                    'max'       => date("Y-m"),
                    'message'   => $message ?? '',
                    'style'     => 'width: 12rem;',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'job_employment_type_id',
                    'label'    => 'employment type',
                    'value'    => old('job_employment_type_id') ?? $job->job_employment_type_id,
                    'required' => true,
                    'list'     => new JobEmploymentType()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'job_location_type_id',
                    'label'    => 'location type',
                    'value'    => old('job_location_type_id') ?? $job->job_location_type_id,
                    'required' => true,
                    'list'     => new JobLocationType()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? $job->street,
                    'street2'    => old('street2') ?? $job->street2,
                    'city'       => old('city') ?? $job->city,
                    'state_id'   => old('state_id') ?? $job->state_id,
                    'states'     => new State()->listOptions([], 'id', 'name', true),
                    'zip'        => old('zip') ?? $job->zip,
                    'country_id' => old('country_id') ?? $job->country_id,
                    'countries'  => new Country()->listOptions([], 'id', 'name', true),
                    'message'    => $message ?? '',
                ])

                @include('admin.components.form-coordinates-horizontal', [
                    'latitude'  => old('latitude') ?? $job->latitude,
                    'longitude' => old('longitude') ?? $job->longitude,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $job->link,
                    'name'    => old('link_name') ?? $job->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $job->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $job->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $job,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $job->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $job->is_public,
                    'is_readonly' => old('is_readonly') ?? $job->is_readonly,
                    'is_root'     => old('is_root')     ?? $job->root,
                    'is_disabled' => old('is_disabled') ?? $job->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $job->is_demo,
                    'sequence'    => old('sequence')    ?? $job->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.job-task.index')
        ])

    </form>

@endsection
