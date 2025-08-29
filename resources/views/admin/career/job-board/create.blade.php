@extends('admin.layouts.default', [
    'title' =>'Add New Job Board',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'url' => route('admin.career.job-board.index') ],
        [ 'name' => 'Create' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.career.job-board.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.career.job-board.store') }}" method="POST">
            @csrf

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name'),
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website'),
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Job Board',
                'cancel_url' => route('admin.career.job-board.index')
            ])

        </form>

    </div>

@endsection
