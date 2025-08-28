@extends('admin.layouts.default', [
    'title' => $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Certifications']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'url' => route('admin.portfolio.certification.edit', $certification) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'url' => route('admin.portfolio.certification.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'url' => route('admin.portfolio.certification.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $certification->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $certification->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => $certification->organization
        ])

        @include('admin.components.show-row', [
            'name'  => 'received',
            'value' => longDate($certification->received)
        ])

        @include('admin.components.show-row', [
            'name'  => 'expiration',
            'value' => longDate($certification->expiration)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $certification->year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $certification->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $certification->personal
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $certification->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $certification->description
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
            'name'    => 'disabled',
            'checked' => $certification->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
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
