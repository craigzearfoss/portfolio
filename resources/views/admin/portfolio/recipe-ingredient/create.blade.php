@extends('admin.layouts.default', [
    'title' =>'Add New Recipe Ingredient',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Recipe Ingredients']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.portfolio.recipe-ingredient.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.portfolio.recipe-ingredient.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => Auth::guard('admin')->user()->id,
                'value' => '0',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => 100,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'slug',

                'value'     => old('slug') ?? '',
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.portfolio.recipe-ingredient.index')
            ])

        </form>

    </div>

@endsection
