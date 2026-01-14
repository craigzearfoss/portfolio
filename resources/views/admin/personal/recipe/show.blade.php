@php
    $buttons = [];
    if (canUpdate($recipe, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.recipe.edit', $recipe) ];
    }
    if (canCreate($recipe, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe', 'href' => route('admin.personal.recipe.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.personal.recipe.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Recipe: ' . $recipe->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipe->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <section class="section">
        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">
                        <ul>
                            <li class="is-active" data-target="overview">
                                <a>Overview</a>
                            </li>
                            <li data-target="ingredients">
                                <a>Ingredients</a>
                            </li>
                            <li data-target="instructions">
                                <a>Instructions</a>
                            </li>
                        </ul>
                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="overview">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-1">Overview</h3>

                                <hr class="navbar-divider">

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

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $recipe->notes
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => !empty($recipe->link_name) ? $recipe->link_name : 'link',
                                    'href'   => $recipe->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $recipe->description
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'disclaimer',
                                    'value' => view('admin.components.disclaimer', [
                                                    'value' => $recipe->disclaimer
                                               ])
                                ])

                                @include('admin.components.show-row-images', [
                                    'resource' => $recipe,
                                    'download' => true,
                                    'external' => true,
                                ])

                                @include('admin.components.show-row-settings', [
                                    'resource' => $recipe,
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

                        </div>

                        <div id="ingredients" class="is-hidden">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-1">

                                    Ingredients

                                    <span style="display: inline-flex; float: right;">

                                        @include('admin.components.link', [
                                            'name'  => 'Edit ingredients',
                                            'href'  => route('admin.personal.recipe-ingredient.index', ['recipe_id' => $recipe->id]),
                                            'class' => 'button is-primary is-small px-1 py-0 mr-2',
                                            'title' => 'edit ingredients',
                                            'icon'  => 'fa-pen-to-square'
                                        ])
                                    </span>

                                </h3>

                                <hr class="navbar-divider">

                                <ul>

                                    @foreach($recipe->ingredients as $ingredient)

                                        <li>
                                            {!! $ingredient->amount !!}
                                            {!! \App\Models\Personal\Unit::find($ingredient->unit_id)->name !!}
                                            {!! \App\Models\Personal\Ingredient::find($ingredient->ingredient_id)->name !!}
                                            @if(!empty($ingredient->qualifier))
                                                - {!! $ingredient->qualifier !!}
                                            @endif
                                        </li>

                                    @endforeach

                                </ul>

                            </div>
                        </div>

                        <div id="instructions" class="is-hidden">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-1">

                                    Instructions

                                    <span style="display: inline-flex; float: right;">

                                        @include('admin.components.link', [
                                            'name'  => 'Edit instructions',
                                            'href'  => route('admin.personal.recipe-step.index', ['recipe_id' => $recipe->id]),
                                            'class' => 'button is-primary is-small px-1 py-0 mr-2',
                                            'title' => 'edit instructions',
                                            'icon'  => 'fa-pen-to-square'
                                        ])
                                    </span>

                                </h3>

                                <hr class="navbar-divider">

                                <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                                    <tbody>

                                    @foreach($recipe->steps as $step)

                                        <tr>
                                            <td>
                                                {!! $step->step !!}
                                            </td>
                                            <td>
                                                {!! $step->description !!}
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
