@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Personal\Recipe;

    $title    = $pageTitle ?? 'Recipes';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Recipes' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Recipe::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe', 'href' => route('admin.personal.recipe.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-recipe',
        [ 'action'     => route('admin.personal.recipe.index'),
          'owner_id'   => $isRootAdmin ? null : $owner->id,
        ]
    )

    <div class="floating-div-container" style="max-width: 60em !important;">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $recipes->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured recipe.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>type</th>
                        <th>meal</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>type</th>
                        <th>meal</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recipes as $recipe)

                    <tr data-id="{{ $recipe->id }}">
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $recipe->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $recipe->name !!}{!! !empty($recipe->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="types">
                            {!! implode(', ', $recipe->types()) !!}
                        </td>
                        <td data-field="meals">
                            {!! implode(', ', $recipe->meals()) !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $recipe->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $recipe->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($recipe, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe.show', [$owner, $recipe]),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($recipe, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe.edit', [$owner, $recipe]),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($recipe->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($recipe->link_name) ? $recipe->link_name : 'link',
                                        'href'   => $recipe->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if(canDelete($recipe, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.personal.recipe.destroy', $recipe) !!}"
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
                        <td colspan="{{ $admin->is_root ? '7' : '6' }}">No recipes found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $recipes->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
