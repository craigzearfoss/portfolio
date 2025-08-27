@extends('admin.layouts.default', [
    'title' => $jobBoard->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Job Boards',      'url' => route('admin.job_board.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.job_board.show', $jobBoard) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.job_board.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.job_board.update', $jobBoard) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? $jobBoard->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'website',
                'value'     => old('website') ?? $jobBoard->website,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save',
                'cancel_url' => route('admin.job_board.index')
            ])

        </form>

    </div>

@endsection
