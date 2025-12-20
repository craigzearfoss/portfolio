@php
    $buttons = [];
    if (canUpdate($jobBoard)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.job-board.edit', $jobBoard) ];
    }
    if (canCreate($jobBoard)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'href' => route('admin.career.job-board.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.job-board.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Job Board: ' . $jobBoard->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'href' => route('admin.career.job-board.index') ],
        [ 'name' => $jobBoard->name ],
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
            'value' => $jobBoard->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobBoard->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $jobBoard->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $jobBoard->primary
        ])

        @include('admin.components.show-row', [
            'name'  => 'coverage area',
            'value' => implode(', ', $jobBoard->coverageAreas ?? [])
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'local',
            'checked' => $jobBoard->local
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'regional',
            'checked' => $jobBoard->regional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'national',
            'checked' => $jobBoard->national
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'international',
            'checked' => $jobBoard->international
        ])

        @include('admin.components.show-row-link', [
            'name'   => $jobBoard->link_name ?? 'link',
            'href'   => $jobBoard->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobBoard->description ?? '')
        ])

        @include('admin.components.show-row-images', [
            'resource' => $jobBoard,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $jobBoard,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobBoard->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobBoard->updated_at)
        ])

    </div>

@endsection
