@extends('admin.layouts.default', [
    'title' => 'Add New Job Board',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Job Boards' ,     'url' => route('admin.job_board.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.job_board.index') ],
    ],
    'errors'  => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.job_board.store') }}" method="POST">
            @csrf

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name'),
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'website',
                'value'     => old('website'),
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Add New Job Board',
                'cancel_url' => route('admin.job_board.index')
            ])

        </form>

    </div>

@endsection
