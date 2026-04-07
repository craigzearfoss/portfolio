@php
    use App\Models\Personal\Reading;

    $title    = $pageTitle ?? filteredPageTitle('readings', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
            [ 'name' => 'Readings' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.personal-reading', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>title</th>
                        <th>author</th>
                        <th class="hide-at-600">type</th>
                        <th class="has-text-centered hide-at-600">published</th>
                        <th class="has-text-centered hide-at-900">paper</th>
                        <th class="has-text-centered hide-at-900">audio</th>
                        <th class="has-text-centered hide-at-900">wish list</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>title</th>
                        <th>author</th>
                        <th class="hide-at-600">type</th>
                        <th class="has-text-centered hide-at-600">published</th>
                        <th class="has-text-centered hide-at-900">paper</th>
                        <th class="has-text-centered hide-at-900">audio</th>
                        <th class="has-text-centered hide-at-900">wish list</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($readings as $reading)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $reading->title,
                                'href'  => route('guest.personal.reading.show', [$owner, $reading->slug]),
                                'class' => $reading->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            {{ $reading->author }}
                        </td>
                        <td data-field="fiction|nonfiction" class="hide-at-600">
                            {{
                                (!empty($reading->fiction) && !empty($reading->nonfiction))
                                    ? 'fiction/nonfiction'
                                    : (!empty($reading->fiction) ? 'fiction' : (!empty($reading->nonfiction) ? 'nonfiction' : ''))
                            }}
                        </td>
                        <td data-field="publication_year" class="has-text-centered hide-at-600">
                            @if($reading->publication_year < 0)
                                {{ abs($reading->publication_year) }} BCE
                            @else
                                {{ $reading->publication_year }}
                            @endif
                        </td>
                        <td class="has-text-centered hide-at-900">
                            @include('guest.components.checkmark', [ 'checked' => $reading->paper ])
                        </td>
                        <td class="has-text-centered hide-at-900">
                            @include('guest.components.checkmark', [ 'checked' => $reading->audio ])
                        </td>
                        <td class="has-text-centered hide-at-900">
                            @include('guest.components.checkmark', [ 'checked' => $reading->wishlist ])
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">No readings found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
