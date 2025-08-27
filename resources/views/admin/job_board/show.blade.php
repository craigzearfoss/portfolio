@extends('admin.layouts.default', [
    'title' => $jobBoard->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Job Boards',      'url' => route('admin.job_board.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.job_board.edit', $jobBoard) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'url' => route('admin.job_board.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => route('admin.job_board.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobBoard->name
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'website',
            'url'    => $jobBoard->website,
            'target' => '_blank'
        ])

    </div>

@endsection
