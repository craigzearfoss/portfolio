@php
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    use App\Models\Personal\Ingredient;
    use App\Models\Personal\Unit;

    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recipe      = $recipe ?? null;

    $title    = 'Edit ' . getResourcePageTitle($recipe);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                 'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                         'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',                           'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',                            'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($recipe, false), 'href' => route('admin.personal.recipe.show', $recipe)  ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.personal.recipe.update', array_merge([$recipe], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.recipe.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $recipe->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $recipe->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $recipe->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
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
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $recipe->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $recipe->summary,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'source',
                    'value'     => old('source') ?? $recipe->source,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'author',
                    'value'     => old('author') ?? $recipe->author,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'prep_time',
                    'label'     => 'prep time (minutes)',
                    'value'     => old('prep_time') ?? $recipe->prep_time,
                    'maxlength' => 3,
                    'message'   => $message ?? '',
                    'style'     => [ 'width: 4rem' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'total_time',
                    'label'     => 'total time (minutes)',
                    'value'     => old('total_time') ?? $recipe->total_time,
                    'maxlength' => 3,
                    'message'   => $message ?? '',
                    'style'     => [ 'width: 4rem' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4" style="width: 44rem;">

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

                            <div class="checkbox-container card form-container p-4" style="width: 36rem;">

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

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $recipe->link,
                    'name'    => old('link_name') ?? $recipe->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $recipe->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $recipe->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $recipe,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $recipe->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $recipe->is_public,
                    'is_readonly' => old('is_readonly') ?? $recipe->is_readonly,
                    'is_root'     => old('is_root')     ?? $recipe->root,
                    'is_disabled' => old('is_disabled') ?? $recipe->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $recipe->is_demo,
                    'sequence'    => old('sequence')    ?? $recipe->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card" style="padding: 1rem !important;">

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

                    @foreach ($recipe->ingredients as $ingredient)

                        <li>
                            {{ $ingredient['amount'] }}
                            {{ Unit::find($ingredient['unit_id'])->abbreviation }}
                            {{ Ingredient::find($ingredient['ingredient_id'])->name }}
                            @if (!empty($ingredient['qualifier']))
                                - {{ $ingredient['qualifier'] }}
                            @endif
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card" style="padding: 1rem !important;">

                <h2 class="subtitle">
                    Instructions
                    <a href="{{ route('admin.personal.recipe-step.index', ['recipe_id' => $recipe->id]) }}"
                       title="edit instructions"
                       class="button is-primary is-small px-1 py-0"
                    >
                        Edit Instructions
                    </a>
                </h2>

                <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="padding: 2rem; max-width: 70rem;">
                    <tbody>

                    @foreach ($recipe->steps as $step)

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

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.personal.recipe.index')
        ])

    </form>

@endsection
