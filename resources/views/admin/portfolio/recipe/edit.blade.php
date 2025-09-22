@extends('admin.layouts.default', [
    'title' => $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('admin.portfolio.recipe.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.portfolio.recipe.update', $recipe) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.recipe.index')
            ])

            @if(Auth::guard('admin')->user()->root)
                @include('admin.components.form-select-horizontal', [
                    'name'    => 'admin_id',
                    'label'   => 'admin',
                    'value'   => old('admin_id') ?? $recipe->admin_id,
                    'list'    => \App\Models\Admin::listOptions(),
                    'message' => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $recipe->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $recipe->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'professional',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('professional') ?? $recipe->professional,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'personal',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('personal') ?? $recipe->personal,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'source',
                'value'     => old('source') ?? $recipe->source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'author',
                'value'     => old('author') ?? $recipe->author,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'prep_time',
                'label'     => 'prep time (minutes)',
                'value'     => old('prep_time') ?? $recipe->prep_time,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'total_time',
                'label'     => 'total time (minutes)',
                'value'     => old('total_time') ?? $recipe->total_time,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'main',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('main') ?? $recipe->main,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'side',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('side') ?? $recipe->side,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'dessert',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('dessert') ?? $recipe->dessert,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'appetizer',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('appetizer') ?? $recipe->appetizer,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'beverage',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('beverage') ?? $recipe->beverage,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'breakfast',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('breakfast') ?? $recipe->breakfast,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'lunch',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('lunch') ?? $recipe->lunch,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'dinner',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('dinner') ?? $recipe->dinner,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'snack',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('snack') ?? $recipe->snack,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $recipe->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? $recipe->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $recipe->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'image',
                'value'     => old('image') ?? $recipe->image,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $recipe->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $recipe->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $recipe->thumbnail,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'sequence',
                'value'   => old('sequence') ?? $recipe->sequence,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $recipe->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $recipe->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $recipe->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $recipe->disabled,
                'message'         => $message ?? '',
            ])

            <div class="card p-4">

                <h2 class="subtitle">
                    Ingredients
                    <a href="{{ route('admin.portfolio.recipe-ingredient.index', ['recipe_id' => $recipe->id]) }}"
                       title="edit ingredients"
                       class="button is-primary is-small px-1 py-0"
                    >
                        Edit Ingredients
                    </a>
                </h2>
                <ul>

                    @foreach($recipe->ingredients as $ingredient)

                        <li>
                            {{ $ingredient['amount'] }}
                            {{ \App\Models\Portfolio\Unit::find($ingredient['unit_id'])->abbreviation }}
                            {{ \App\Models\Portfolio\Ingredient::find($ingredient['ingredient_id'])->name }}
                            @if(!empty($ingredient['qualifier']))
                                - {{ $ingredient['qualifier'] }}
                            @endif
                        </li>

                    @endforeach

                </ul>

            </div>

            <div class="card p-4">

                <h2 class="subtitle">
                    Instructions
                    <a href="{{ route('admin.portfolio.recipe-step.index', ['recipe_id' => $recipe->id]) }}"
                       title="edit instructions"
                       class="button is-primary is-small px-1 py-0"
                    >
                        Edit Instructions
                    </a>
                </h2>
                <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                    <tbody>

                    @foreach($recipe->steps as $step)

                        <tr>
                            <td>
                                {{ $step['step'] }}
                            </td>
                            <td>
                                {{ $step['description'] }}
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.recipe.index')
            ])

        </form>

    </div>

@endsection
