@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Award';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('awards', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Award' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-award', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($awards->total()) }} {{ ($awards->total() === 1) ? 'award' : 'awards' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $awards->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'category',
                                'sort'  => 'category|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'nominated work',
                                'sort'  => 'nominated_work|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'award_year|asc',
                            ])
                        </th>
                        <th class="hide-at-1300">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'organization',
                                'sort'  => 'organization|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($awards as $award)

                    <tr {!! $award->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($award->name),
                                'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                'class' => $award->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if (!empty($award->category))
                                @include('guest.components.link', [
                                    'name'  => ($award->category),
                                    'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                    'class' => $award->featured ? 'has-text-weight-bold' : ''
                                ])
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            {!! htmlspecialchars($award->nominated_work) !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $award->award_year !!}
                        </td>
                        <td class="hide-at-1300" style="white-space: nowrap;">
                            {!! htmlspecialchars($award->organization) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No awards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $awards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
