@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title   = $pageTitle ?? filteredPageTitle('photography', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Photography' ],
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

    @include('guest.components.search-panel.portfolio-photography', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th class="hide-at-480">credit</th>
                        <th class="has-text-centered hide-at-750">year</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="hide-at-480">credit</th>
                        <th class="has-text-centered hide-at-750">year</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($photos as $photo)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $photo->name,
                                'href'  => route('guest.portfolio.photography.show', [$owner, $photo->slug]),
                                'class' => $photo->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td class="hide-at-480" style="white-space: nowrap;">
                            {!! $photo->credit !!}
                        </td>
                        <td class="has-text-centered hide-at-750">
                            {!! $photo->photo_year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No photos found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
