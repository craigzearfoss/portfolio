@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Recruiter: ' . $recruiter->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => $recruiter->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $recruiter, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.recruiter.edit', $recruiter)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recruiter', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recruiter', 'href' => route('admin.career.recruiter.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.recruiter.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recruiter->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $recruiter->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recruiter->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'coverage area',
            'value' => implode(', ', $recruiter->coverageAreas ?? [])
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'postings url',
            'label'  => $recruiter->postings_url,
            'href'   => $recruiter->postings_url),
            'target' => '_blank'
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'local',
            'checked' => $recruiter->local
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'regional',
            'checked' => $recruiter->regional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'national',
            'checked' => $recruiter->national
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'international',
            'checked' => $recruiter->international
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $recruiter->street,
                           'street2'         => $recruiter->street2,
                           'city'            => $recruiter->city,
                           'state'           => $recruiter->state->code ?? '',
                           'zip'             => $recruiter->zip,
                           'country'         => $recruiter->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $recruiter
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->phone_label) ? $recruiter->phone_label : 'phone',
            'value' => $recruiter->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->alt_phone_label) ? $recruiter->alt_phone_label : 'alt phone',
            'value' => $recruiter->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->email_label) ? $recruiter->email_label : 'email',
            'value' => $recruiter->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->alt_email_label) ? $recruiter->alt_email_label : 'alt email',
            'value' => $recruiter->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($recruiter->link_name) ? $recruiter->link_name : 'link',
            'href'   => $recruiter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recruiter->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recruiter,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $recruiter,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recruiter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recruiter->updated_at)
        ])

    </div>

@endsection
