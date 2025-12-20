@php
    $buttons = [];
    if (canUpdate($recruiter, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.recruiter.edit', $recruiter) ];
    }
    if (canCreate($recruiter, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'href' => route('admin.career.recruiter.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.recruiter.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Recruiter: ' . $recruiter->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => $recruiter->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

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
            'href'   => $recruiter->postings_url,
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
                           'street'          => htmlspecialchars($recruiter->street),
                           'street2'         => htmlspecialchars($recruiter->street2),
                           'city'            => htmlspecialchars($recruiter->city),
                           'state'           => htmlspecialchars($recruiter->state->code),
                           'zip'             => $recruiter->zip ?? null,
                           'country'         => htmlspecialchars($recruiter->country->iso_alpha3),
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
            'name'   => $recruiter->link_name ?? 'link',
            'href'   => $recruiter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recruiter->description ?? '')
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recruiter,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
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
