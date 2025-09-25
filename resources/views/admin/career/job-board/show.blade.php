@extends('admin.layouts.default', [
    'title' => $jobBoard->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'url' => route('admin.career.job-board.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'url' => route('admin.career.job-board.edit', $jobBoard) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'url' => route('admin.career.job-board.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'url' => referer('admin.career.job-board.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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
            'name'  => 'link',
            'url'    => $jobBoard->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $jobBoard->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobBoard->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $jobBoard->image,
            'alt'      => $jobBoard->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobBoard->name, $jobBoard->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $jobBoard->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $jobBoard->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $jobBoard->thumbnail,
            'alt'      => $jobBoard->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobBoard->name, $jobBoard->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $jobBoard->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $jobBoard->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $jobBoard->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $jobBoard->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $jobBoard->disabled
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
