@php
    $buttons = [];
    if (canUpdate($school, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.school.edit', $school) ];
    }
    if (canCreate($school, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New School', 'href' => route('admin.portfolio.school.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.school.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'School: ' . $school->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools',         'href' => route('admin.portfolio.school.index') ],
        [ 'name' => $school->name ],
    ],
    'buttons' => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $school->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $school->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $school->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => $school->enrollment
        ])

        @include('admin.components.show-row', [
            'name'  => 'founded',
            'value' => $school->founded
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($school->street),
                           'street2'         => htmlspecialchars($school->street2),
                           'city'            => htmlspecialchars($school->city),
                           'state'           => $school->state->code ?? '',
                           'zip'             => htmlspecialchars($school->zip),
                           'country'         => $school->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $school
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($school->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $school->link_name ?? 'link',
            'href'   => $school->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($school->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $school->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $school,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $school,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($school->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($school->updated_at)
        ])

    </div>

@endsection
