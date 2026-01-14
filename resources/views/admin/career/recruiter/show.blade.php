@php
    $buttons = [];
    if (canUpdate($recruiter, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.recruiter.edit', $recruiter) ];
    }
    if (canCreate($recruiter, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'href' => route('admin.career.recruiter.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.recruiter.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Recruiter: ' . $recruiter->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => $recruiter->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recruiter->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($recruiter->name ?? '')
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
            'label'  => htmlspecialchars($recruiter->postings_url ?? ''),
            'href'   => htmlspecialchars($recruiter->postings_url ?? ''),
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
                           'street'          => htmlspecialchars($recruiter->street ?? ''),
                           'street2'         => htmlspecialchars($recruiter->street2 ?? ''),
                           'city'            => htmlspecialchars($recruiter->city ?? ''),
                           'state'           => $recruiter->state->code ?? '',
                           'zip'             => htmlspecialchars($recruiter->zip ?? ''),
                           'country'         => $recruiter->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $recruiter
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($recruiter->phone_label) ? $recruiter->phone_label : 'phone'),
            'value' => htmlspecialchars($recruiter->phone ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($recruiter->alt_phone_label) ? $recruiter->alt_phone_label : 'alt phone'),
            'value' => htmlspecialchars($recruiter->alt_phone ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($recruiter->email_label) ? $recruiter->email_label : 'email'),
            'value' => htmlspecialchars($recruiter->email ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($recruiter->alt_email_label) ? $recruiter->alt_email_label : 'alt email'),
            'value' => htmlspecialchars($recruiter->alt_email ?? '')
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($recruiter->link_name ?? 'link'),
            'href'   => htmlspecialchars($recruiter->link ? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recruiter->description ?? ''
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
