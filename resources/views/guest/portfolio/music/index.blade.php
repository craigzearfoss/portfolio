@php
    $title    = $pageTitle ?? filteredPageTitle('music', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Music' ],
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

    @include('guest.components.search-panel.portfolio-music', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container" style="max-width: 80em !important;">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>artist</th>
                        <th class="has-text-centered hide-at-600">year</th>
                        <th class="hide-at-750">label</th>
                        <th class="hide-at-900">cat#</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>artist</th>
                        <th class="has-text-centered hide-at-600">year</th>
                        <th class="hide-at-750">label</th>
                        <th class="hide-at-900">cat#</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($musics as $music)

                    <tr data-id="{{ $music->id }}">
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name'  => $music->name,
                                'href'  => route('guest.portfolio.music.show', [$owner, $music->slug]),
                                'class' => $music->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="artist">
                            {!! $music->artist !!}
                        </td>
                        <td data-field="year" class="has-text-centered hide-at-600">
                            {!! $music->year !!}
                        </td>
                        <td data-field="label" class="hide-at-750">
                            {!! $music->label !!}
                        </td>
                        <td data-field="catalog_number" class="hide-at-900">
                            {!! $music->catalog_number !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No music found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
