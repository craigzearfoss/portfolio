@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Art';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('art', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Art' ],
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

    @include('guest.components.search-panel.portfolio-art', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" >

            <p><i>{{ number_format($arts->total()) }} {{ ($arts->total() === 1) ? 'art' : 'arts' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 30rem; max-width: 50rem; overflow-x: auto; overflow-y: hidden;">

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
                                'name'  => 'artist',
                                'sort'  => 'artist|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'art_year|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($arts as $art)

                    <tr data-id="{{ $art->id }}" {!! $art->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($art->name),
                                'href'  => route('guest.portfolio.art.show', [$owner, $art->slug]),
                                'class' => $art->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('admin.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.art', 'data-id' => $art->id ]
                            ])
                            */ ?>
                        </td>
                        <td style="white-space: nowrap;">
                            {!! htmlspecialchars($art->artist) !!}
                        </td>
                        <td class="has-text-centered hide-at-480">
                            {!! $art->art_year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No art found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
