@extends('admin.layouts.default', [
    'title' => $skill->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Skills']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.career.resume.skill.edit', $skill) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'url' => route('admin.career.resume.skill.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.career.resume.skill.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $skill->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $skill->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $skill->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'sequence',
            'checked' => $skill->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $skill->public
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
