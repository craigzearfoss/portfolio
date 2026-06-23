@php
    use App\Models\Career\RecruiterIndustry;
    use App\Models\System\Country;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recruiter   = $recruiter ?? null;

    $title    = $pageTitle ?? 'Add New Recruiter';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => 'Add' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.recruiter.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.recruiter.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.recruiter.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? 0,
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'primary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('primary') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
                'style'     => [ 'max-width: 40rem !important' ]
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'recruiter_industry_id',
                'label'    => 'industry',
                'value'    => old('recruiter_industry_id') ??'',
                'list'     => new RecruiterIndustry()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <strong>coverage areas</strong>
                </div>
                <div class="field-body">
                    <div class="field" style="flex-grow: 0;">

                        @include('admin.components.form-coverage-areas', [
                            'resource' => $recruiter
                        ])

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'founded',
                'value'   => old('founded') ?? '',
                'min'     => 1800,
                'max'     => date("Y"),
                'message' => $message ?? '',
                'style'   => [ 'width: 6rem' ]
            ])

            @include('admin.components.form-link-horizontal', [
                'name'               => 'linkedin_url',
                'label'              => 'linkedin url',
                'link'               => old('linkedin_url') ?? '',
                'include_name_field' => false,
                'message'            => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'name'               => 'jobs_url',
                'label'              => 'jobs url',
                'link'               => old('jobs_url') ?? '',
                'include_name_field' => false,
                'message'            => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? '',
                'street2'    => old('street2') ?? '',
                'city'       => old('city') ?? '',
                'state_id'   => old('state_id') ?? '',
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? '',
                'country_id' => old('country_id') ?? '',
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? '',
                'longitude' => old('longitude') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? '',
                'label' => old('phone_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? '',
                'label'   => old('alt_phone_label') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? '',
                'label'   => old('email_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? '',
                'label'   => old('alt_email_table') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save Recruiter',
                'cancel_url' => referer('admin.career.recruiter.index')
            ])

        </form>

    </div>

@endsection
