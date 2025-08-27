@extends('admin.layouts.default', [
    'title' => 'Add New Stack',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',  'url' => route('admin.dashboard')],
        [ 'name' => 'Stacks',           'url' => route('admin.dictionary_stack.index')],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.dictionary_stack.index') ],
    ],
    'errors'  => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="form-container">

        <form action="{{ route('admin.dictionary_stack.store') }}" method="POST">
            @csrf

            @include('admin.components.form-input', [
                'name'      => 'full_name',
                'value'     => old('full_name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'slug',
                'value'     => old('slug') ?? '',
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'website',
                'value'     => old('website') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'wiki_page',
                'label'     => 'wiki page',
                'value'     => old('wiki_page') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Add Stack',
                'cancel_url' => route('admin.dictionary_stack.index')
            ])

        </form>

    </div>

@endsection
