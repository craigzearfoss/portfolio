@php
    use App\Models\Personal\RecipeStep;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($recipe->name) ?  $recipe->name . ' Instructions' : 'Recipe Instructions');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
            [ 'name' => $recipe->name,     'href' => route('admin.personal.recipe.show', $recipe) ],
            [ 'name' => 'Steps' ],
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(RecipeStep::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Step', 'href' => route('admin.personal.recipe-step.create', $owner)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-recipe-step', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        @if(empty($recipeId))
                            <th>recipe</th>
                        @endif
                        <th class="has-text-centered">step</th>
                        <th>description</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        @if(empty($recipeId))
                            <th>recipe</th>
                        @endif
                        <th class="has-text-centered">step</th>
                        <th>description</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recipeSteps as $recipeStep)

                    <tr data-id="{{ $recipeStep->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $recipeStep->owner->username ?? '' }}
                            </td>
                        @endif
                        @if(empty($recipeId))
                            <td data-field="recipe.name">
                                @if(!empty($recipeStep->recipe))
                                    @include('admin.components.link', [
                                        'name' => $recipeStep->recipe->name ?? '',
                                        'href' => route('admin.personal.recipe.show', $recipeStep->recipe)
                                    ])
                                @endif
                            </td>
                        @endif
                        <td data-field="step" class="has-text-centered">
                            {!! $recipeStep->step !!}
                        </td>
                        <td data-field="description">
                            {!! $recipeStep->description !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe-step.show', $recipeStep),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe-step.edit', $recipeStep),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($recipeStep, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.personal.recipe-step.destroy', $recipeStep) !!}"
                                          method="POST">
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
                            $cols = $isRootAdmin ? '4' : '3';
                            if (!empty($recipeId)) $cols++;
                        @endphp
                        <td colspan="{{ $cols }}">No recipe steps found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
