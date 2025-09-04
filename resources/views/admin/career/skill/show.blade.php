@extends('admin.layouts.default', [
    'title' => $skill->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Skills',          'url' => route('admin.career.skill.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.career.skill.edit', $skill) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'url' => route('admin.career.skill.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.career.skill.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

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
            'value' => $resume->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $resume->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $resume->image_source
        ])

        @include('admin.components.show-row', [
            'name'  => 'thumbnail',
            'value' => $resume->thumbnail
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

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($skill->deleted_at)
        ])

    </div>

@endsection
