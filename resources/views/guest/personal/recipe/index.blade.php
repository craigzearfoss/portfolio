@php
    $title    = $pageTitle ?? $owner->name . ' recipes';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
        [ 'name' => 'Recipes' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>meal</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>meal</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
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
                        <td data-field="meals">
                            {{ implode(', ', $recipe->meals()) }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">There are no recipes.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $recipes->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
