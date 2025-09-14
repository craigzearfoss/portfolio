@extends('admin.layouts.default', [
    'title' => $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',  'url' => route('admin.portfolio.certification.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'url' => route('admin.portfolio.certification.edit', $certification) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'url' => route('admin.portfolio.certification.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'url' => route('admin.portfolio.certification.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $certification->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $certification->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $certification->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $certification->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => $certification->organization
        ])

        @include('admin.components.show-row', [
            'name'  => 'academy',
            'value' => $certification->academy['name']
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $certification->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'received',
            'value' => longDate($certification->received)
        ])

        @include('admin.components.show-row', [
            'name'  => 'expiration',
            'value' => longDate($certification->expiration)
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $certification->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $certification->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $certification->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $certification->image,
            'alt'   => $certification->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $certification->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $certification->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $certification->thumbnail,
            'alt'   => $certification->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $certification->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $certification->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $certification->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $certification->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $certification->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $certification->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($certification->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($certification->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($certification->deleted_at)
        ])

    </div>

@endsection
