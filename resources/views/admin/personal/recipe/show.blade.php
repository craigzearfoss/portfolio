@php
    $buttons = [];
    if (canUpdate($recipe)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.recipe.edit', $recipe) ];
    }
    if (canCreate($recipe)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe', 'href' => route('admin.personal.recipe.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.personal.recipe.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Recipe: ' . $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipe->name ],
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipe->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $recipe->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($recipe->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recipe->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $recipe->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($recipe->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'source',
            'value' => htmlspecialchars($recipe->source)
        ])

        @include('admin.components.show-row', [
            'name'  => 'author',
            'value' => htmlspecialchars($recipe->author)
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'prep time',
            'checked' => !empty($recipe->prep_time) ? ($recipe->prep_time . ' minutes') : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'total time',
            'checked' => !empty($recipe->total_time) ? ($recipe->total_time . ' minutes') : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'main',
            'checked' => $recipe->main
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'side',
            'checked' => $recipe->side
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'dessert',
            'checked' => $recipe->dessert
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'appetizer',
            'checked' => $recipe->appetizer
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'beverage',
            'checked' => $recipe->beverage
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'breakfast',
            'checked' => $recipe->breakfast
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'lunch',
            'checked' => $recipe->lunch
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'dinner',
            'checked' => $recipe->dinner
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'snack',
            'checked' => $recipe->snack
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($recipe->notes))
        ])

        @if(!empty($recipe->link))
            @include('admin.components.show-row-link', [
                'name'   => $recipe->link_name,
                'href'   => $recipe->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recipe->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $recipe->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recipe,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $recipe->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recipe->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $recipe->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recipe->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recipe->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recipe->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recipe->updated_at)
        ])

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
                    {{ \App\Models\Personal\Unit::find($ingredient['unit_id'])->name }}
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

@endsection
