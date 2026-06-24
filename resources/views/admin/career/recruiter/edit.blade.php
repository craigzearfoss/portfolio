@php
    use App\Models\Career\RecruiterIndustry;
    use App\Models\System\Country;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recruiter   = $recruiter ?? null;

    $title    = 'Edit ' . getResourcePageTitle($recruiter);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                       'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                                'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',                            'href' => route('admin.career.recruiter.index') ],
        [ 'name' => getResourcePageTitle($recruiter, false), 'href' => route('admin.career.recruiter.show', $recruiter) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.recruiter.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.recruiter.update', array_merge([$recruiter], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.recruiter.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $recruiter->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $recruiter->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? $recruiter->name,
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-checkbox-horizontal', [
                        'name'            => 'primary',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => old('primary') ?? $recruiter->primary,
                        'message'         => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'summary',
                        'value'     => old('summary') ?? $recruiter->summary,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'style'     => [ 'max-width: 40rem !important' ]
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'recruiter_industry_id',
                        'label'    => 'industry',
                        'value'    => old('recruiter_industry_id') ?? $recruiter->recruiter_industry_id,
                        'list'     => new RecruiterIndustry()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'    => 'number',
                        'name'    => 'founded',
                        'value'   => old('founded') ?? $recruiter->founded,
                        'min'     => 1800,
                        'max'     => date("Y"),
                        'message' => $message ?? '',
                        'style'   => [ 'width: 6rem' ]
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">coverage areas</label>
                        </div>
                        <div class="field-body">
                            <div class="field" style="flex-grow: 0;">

                                @include('admin.components.form-coverage-areas', [
                                    'resource' => $recruiter
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
                        'link'               => old('linkedin_url') ?? $recruiter->linkedin_url,
                        'include_name_field' => false,
                        'message'            => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'               => 'jobs_url',
                        'label'              => 'jobs url',
                        'link'               => old('jobs_url') ?? $recruiter->jobs_url,
                        'include_name_field' => false,
                        'message'            => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-location-horizontal', [
                        'street'     => old('street') ?? $recruiter->street,
                        'street2'    => old('street2') ?? $recruiter->street2,
                        'city'       => old('city') ?? $recruiter->city,
                        'state_id'   => old('state_id') ?? $recruiter->state_id,
                        'states'     => new State()->listOptions([], 'id', 'name', true),
                        'zip'        => old('zip') ?? $recruiter->zip,
                        'country_id' => old('country_id') ?? $recruiter->country_id,
                        'countries'  => new Country()->listOptions([], 'id', 'name', true),
                        'message'    => $message ?? '',
                    ])

                    @include('admin.components.form-coordinates-horizontal', [
                        'latitude'  => old('latitude') ?? $recruiter->latitude,
                        'longitude' => old('longitude') ?? $recruiter->longitude,
                        'message'   => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-phone-horizontal', [
                        'phone' => old('phone') ?? $recruiter->phone,
                        'label' => old('phone_label') ?? $recruiter->phone_label,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-phone-horizontal', [
                        'phone'   => old('alt_phone') ?? $recruiter->alt_phone,
                        'label'   => old('alt_phone_label') ?? $recruiter->alt_phone_label,
                        'alt'     => true,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-email-horizontal', [
                        'email'   => old('email') ?? $recruiter->email,
                        'label'   => old('email_label') ?? $recruiter->email_label,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-email-horizontal', [
                        'email'   => old('alt_email') ?? $recruiter->alt_email,
                        'label'   => old('alt_email_table') ?? $recruiter->alt_email_label,
                        'alt'     => true,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link' => old('link') ?? $recruiter->link,
                        'name' => old('link_name') ?? $recruiter->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $recruiter->description,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.show-row-images', [
                        'resource' => $recruiter,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $recruiter->notes,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $recruiter->is_public,
                        'is_readonly' => old('is_readonly') ?? $recruiter->is_readonly,
                        'is_root'     => old('is_root')     ?? $recruiter->root,
                        'is_disabled' => old('is_disabled') ?? $recruiter->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $recruiter->is_demo,
                        'sequence'    => old('sequence')    ?? $recruiter->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.recruiter.index')
            ])

        </form>

    </div>

@endsection
