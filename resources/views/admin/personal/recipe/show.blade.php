@extends('admin.layouts.default', [
    'title' => 'Recipe: ' . $recipe->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipe->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'href' => route('admin.personal.recipe.edit', $recipe) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe', 'href' => route('admin.personal.recipe.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'href' => referer('admin.personal.recipe.index') ],
    ],
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
                'value' => $recipe->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recipe->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $recipe->name
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
            'value' => $recipe->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'source',
            'value' => $recipe->source
        ])

        @include('admin.components.show-row', [
            'name'  => 'author',
            'value' => $recipe->author
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

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'    => $recipe->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link name',
            'value'  => $recipe->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($recipe->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $recipe->image,
            'alt'   => $recipe->name,
            'width' => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recipe->name, $recipe->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $recipe->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $recipe->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $recipe->thumbnail,
            'alt'   => $recipe->name,
            'width' => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recipe->name, $recipe->image)
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
