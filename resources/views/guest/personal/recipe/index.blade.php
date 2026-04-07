@php
    $title    = $pageTitle ?? filteredPageTitle('recipes', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
            [ 'name' => 'Recipes' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.search-panel.personal-recipe', [ 'owner_id' => $owner->id ?? null ])

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container" style="max-width: 70em !important;">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $recipes->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>type</th>
                        <th class="hide-at-600">meal</th>
                        <th class="hide-at-750">author</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>type</th>
                        <th class="hide-at-600">meal</th>
                        <th class="hide-at-750">author</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recipes as $recipe)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $recipe->name,
                                'href'  => route('guest.personal.recipe.show', [$owner, $recipe->slug]),
                                'class' => $recipe->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="types">
                            {{ implode(', ', $recipe->types()) }}
                        </td>
                        <td data-field="meals" class="hide-at-600">
                            {{ implode(', ', $recipe->meals()) }}
                        </td>
                        <td data-field="author" class="hide-at-750">
                            {{ $recipe->author }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No recipes found.</td>
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
