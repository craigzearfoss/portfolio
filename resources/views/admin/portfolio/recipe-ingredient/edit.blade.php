@extends('admin.layouts.default', [
    'title' => $recipeIngredient->name,
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

        <form action="{{ route('admin.portfolio.recipe-ingredient.update', $recipeIngredient) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
                'value' => '0',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $recipeIngredient->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'slug',
                'value'     => old('slug') ?? $recipeIngredient->slug,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $recipeIngredient->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => route('admin.portfolio.recipe-ingredient.index')
                ])

        </form>

    </div>

@endsection
