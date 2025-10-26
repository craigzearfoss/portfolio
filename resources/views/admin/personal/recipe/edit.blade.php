@extends('admin.layouts.default', [
    'title' => 'Recipe: ' . $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipe->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.recipe.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.recipe.update', $recipe) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.recipe.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $recipe->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $recipe->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $recipe->owner_id
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

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $recipe->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
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

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'main',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('main') ?? $recipe->main,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'side',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('side') ?? $recipe->side,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'dessert',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('dessert') ?? $recipe->dessert,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'appetizer',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('appetizer') ?? $recipe->appetizer,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'beverage',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('beverage') ?? $recipe->beverage,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'breakfast',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('breakfast') ?? $recipe->breakfast,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'lunch',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('lunch') ?? $recipe->lunch,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'dinner',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('dinner') ?? $recipe->dinner,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'snack',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('snack') ?? $recipe->snack,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $recipe->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $recipe->link,
                'maxlength' => 500,
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
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'sequence',
                'value'   => old('sequence') ?? $recipe->sequence,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? $recipe->public,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? $recipe->readonly,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'root',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('root') ?? $recipe->root,
                                'disabled'        => !isRootAdmin(),
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? $recipe->disabled,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="card p-4">

                <h2 class="subtitle">
                    Ingredients
                    <a href="{{ route('admin.personal.recipe-ingredient.index', ['recipe_id' => $recipe->id]) }}"
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
                            {{ \App\Models\Personal\Unit::find($ingredient['unit_id'])->abbreviation }}
                            {{ \App\Models\Personal\Ingredient::find($ingredient['ingredient_id'])->name }}
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
                    <a href="{{ route('admin.personal.recipe-step.index', ['recipe_id' => $recipe->id]) }}"
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
                'cancel_url' => referer('admin.personal.recipe.index')
            ])

        </form>

    </div>

@endsection
