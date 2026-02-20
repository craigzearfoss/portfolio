@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
        $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    }
    $breadcrumbs[] = [ 'name' => $recipe->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $recipe, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.recipe.edit', $recipe)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recipe', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe', 'href' => route('admin.personal.recipe.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Recipe: ' . $recipe->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

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

                        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
                        </div>

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

                                @if($admin->root)
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

                                @include('admin.components.show-row-visibility', [
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

                                <table class="table admin-table recipe-instruction-table {{ $adminTableClasses ?? '' }}">
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
    </div>

@endsection
