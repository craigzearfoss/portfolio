@extends('admin.layouts.default', [
    'title' => 'School: ' . $school->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools',         'href' => route('admin.portfolio.school.index') ],
        [ 'name' => $school->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.school.edit', $school) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New School',   'href' => route('admin.portfolio.school.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.school-task.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                           'street'    => $school->street ?? null,
                           'street2'   => $school->street2 ?? null,
                           'city'      => $school->city ?? null,
                           'state'     => $school->state['code'] ?? null,
                           'zip'       => $school->zip ?? null,
                           'country'   => $school->country['iso_alpha3'] ?? null,
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $school->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $school->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $school->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $school->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $school->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($school->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $school->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($school->name, $school->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $school->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $school->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $school->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($school->name . '-thumb', $school->thumbnail)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo',
            'src'   => $school->logo,
            'alt'   => 'logo',
            'width' => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($school->name . '-logo', $school->logo)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo small',
            'src'   => $school->logo_small,
            'alt'   => 'logo small',
            'width' => '100px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($school->name . '-logo-sm', $school->logo_small)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $school->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $school->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $school->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $school->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $school->disabled
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
