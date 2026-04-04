@php
    $title    = $pageTitle ?? filteredPageTitle('art', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Art' ],
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

    @include('guest.components.search-panel.portfolio-art', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container" style="max-width: 60em !important;">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>artist</th>
                        <th class="has-text-centered hide-at-480">year</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>artist</th>
                        <th class="has-text-centered hide-at-480">year</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($arts as $art)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $art->name,
                                'href'  => route('guest.portfolio.art.show', [$owner, $art->slug]),
                                'class' => $art->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            {!! $art->artist !!}
                        </td>
                        <td class="has-text-centered hide-at-480">
                            {!! $art->year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No art found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
