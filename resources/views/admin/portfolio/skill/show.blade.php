@extends('admin.layouts.default', [
    'title' => $skill->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills',          'url' => route('admin.portfolio.skill.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.portfolio.skill.edit', $skill) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'url' => route('admin.portfolio.skill.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => referer('admin.portfolio.skill.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row-rating', [
            'name'  => 'rating',
            'value' => $application->rating
        ])

        @include('admin.components.show-row', [
            'name'    => 'years',
            'checked' => $application->years
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $skill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'url'    => $skill->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $skill->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $skill->image,
            'alt'   => $skill->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $skill->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $skill->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $skill->thumbnail,
            'alt'   => $skill->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $skill->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $skill->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $skill->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $skill->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $skill->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($skill->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($skill->updated_at)
        ])

    </div>

@endsection
