@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('publications', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Publications' ],
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

    @include('guest.components.search-panel.portfolio-publication', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $publications->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>title</th>
                        <th class="hide-at-480">publication</th>
                        <th class="hide-at-1200">publisher</th>
                        <th class="has-text-centered hide-at-750">year</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>title</th>
                        <th class="hide-at-480">publication</th>
                        <th class="hide-at-1200">publisher</th>
                        <th class="hide-at-750">year</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($publications as $publication)

                    <tr data-id="{{ $publication->id }}">
                        <td data-field="title" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $publication->title,
                                'href'  => route('guest.portfolio.publication.show', [$owner, $publication->slug]),
                                'class' => $publication->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="publication_name" class="hide-at-480" style="white-space: nowrap;">
                            {!! $publication->publication_name !!}
                        </td>
                        <td data-field="publisher" class="hide-at-1200" style="white-space: nowrap;">
                            {!! $publication->publisher !!}
                        </td>
                        <td data-field="publication_year" class="has-text-centered hide-at-750">
                            {!! $publication->publication_year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No publications found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $publications->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
