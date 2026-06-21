@php
    use App\Models\Personal\RecipeStep;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Personal\RecipeStep';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($recipe->name) ?  $recipe->name . ' Instructions' : 'Recipe Instructions');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ]
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => 'Steps' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(RecipeStep::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Recipe Step',
                                                                  'href' => route('admin.personal.recipe-step.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-recipe-step', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.personal.recipe-step.export', request()->except([ 'page' ])),
                'filename' => 'recipe_steps_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($recipeSteps->total()) }} {{ ($recipeSteps->total() === 1) ? 'recipe step' : 'recipe steps' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the recipe step is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'recipe',
                                'sort'  => 'recipe_name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'step',
                                'sort'  => 'step|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'description',
                                'sort'  => 'description|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($recipeSteps as $recipeStep)

                    <tr data-id="{{ $recipeStep->id }}" {!! $recipeStep->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $recipeStep->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $recipeStep->owner->username,
                                    'href'  => route('admin.system.admin.show', $recipeStep->owner),
                                    'class' => $recipeStep->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        @if (empty($recipeId))
                            <td data-field="recipe.name" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $recipeStep->recipe->name . (!empty($recipeStep->recipe->featured) ? '<span class="featured-splat">*</span>' : ''),
                                    'href'  => route('admin.personal.recipe.show', $recipeStep->recipe),
                                    'class' => $recipeStep->is_disabled ? [ 'disabled-text' ] : []
                               ])
                            </td>
                        @endif
                        <td data-field="step" class="has-text-centered">
                            @include('admin.components.link', [
                                'name'  => $recipeStep->step,
                                'href'  => route('admin.personal.recipe-step.show', $recipeStep),
                                'class' => $recipeStep->is_disabled ? [ 'disabled-text' ] : []
                           ])
                        </td>
                        <td data-field="description">
                            {!! $recipeStep->description !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe-step.show', ownerParams($recipeStep, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe-step.edit', ownerParams($recipeStep, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($recipeStep, $admin))
                                    <form class="delete-resource" action="{!! route('admin.personal.recipe-step.destroy', $recipeStep) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        @php
                            $cols = $isRootAdmin ? '5' : '3';
                            if (!empty($recipeId)) $cols++;
                        @endphp
                        <td colspan="{{ $cols }}">No recipe steps found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
