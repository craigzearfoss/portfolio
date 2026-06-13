@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Academy';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Academies';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Academies' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <?php /*
    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif
    */ ?>

    @include('guest.components.search-panel.portfolio-academy', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($academies->total()) }} {{ ($academies->total() === 1) ? 'academy' : 'academies' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $academies->links('vendor.pagination.bulma') !!}
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
                                'sort'  => 'academy_year|asc',
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

                @forelse ($academies as $academy)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($academy->name),
                                'href'  => route('guest.portfolio.academy.show', [$owner, $academy->slug]),
                                'class' => $academy->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if (!empty($academy->category))
                                @include('guest.components.link', [
                                    'name'  => ($academy->category),
                                    'href'  => route('guest.portfolio.academy.show', [$owner, $academy->slug]),
                                    'class' => $academy->featured ? 'has-text-weight-bold' : ''
                                ])
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            {!! htmlspecialchars($academy->nominated_work) !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $academy->academy_year !!}
                        </td>
                        <td class="hide-at-1300" style="white-space: nowrap;">
                            {!! htmlspecialchars($academy->organization) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No academies found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $academies->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
