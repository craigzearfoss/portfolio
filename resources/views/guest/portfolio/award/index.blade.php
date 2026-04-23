@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('awards', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Award' ],
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

    @include('guest.components.search-panel.portfolio-award', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $awards->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>category</th>
                        <th>nominated work</th>
                        <th class="has-text-centered">year</th>
                        <th class="hide-at-1300">organization</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>category</th>
                        <th>nominated work</th>
                        <th class="has-text-centered">year</th>
                        <th class="hide-at-1300">organization</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($awards as $award)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $award->name,
                                'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                'class' => $award->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if(!empty($award->category))
                                @include('guest.components.link', [
                                    'name'  => $award->category,
                                    'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                    'class' => $award->featured ? 'has-text-weight-bold' : ''
                                ])
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            {!! $award->nominated_work !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $award->award_year !!}
                        </td>
                        <td class="hide-at-1300" style="white-space: nowrap;">
                            {!! $award->organization !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No awards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $awards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
