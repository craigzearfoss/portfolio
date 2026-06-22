@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Music';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('music', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Music' ],
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

    @include('guest.components.search-panel.portfolio-music', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($musics->total()) }} {{ ($musics->total() === 1) ? 'music' : 'musics' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $musics->links('vendor.pagination.bulma') !!}
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
                                'name'  => 'artist',
                                'sort'  => 'artist|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-600">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'music_year|asc',
                            ])
                        </th>
                        <th class="hide-at-750">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'label',
                                'sort'  => 'label|asc',
                            ])
                        </th>
                        <th class="hide-at-900">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'cat#',
                                'sort'  => 'catalog_number|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($musics as $music)

                    <tr data-id="{{ $music->id }}" {!! $music->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($music->name),
                                'href'  => route('guest.portfolio.music.show', [$owner, $music->slug]),
                                'class' => $music->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('admin.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.music', 'data-id' => $music->id ]
                            ])
                            */ ?>
                        </td>
                        <td data-field="artist" style="white-space: nowrap;">
                            {!! htmlspecialchars($music->artist) !!}
                        </td>
                        <td data-field="year" class="has-text-centered hide-at-600" style="white-space: nowrap;">
                            {!! $music->music_year !!}
                        </td>
                        <td data-field="label" class="hide-at-750" style="white-space: nowrap;">
                            {!! htmlspecialchars($music->label) !!}
                        </td>
                        <td data-field="catalog_number" class="hide-at-900" style="white-space: nowrap;">
                            {!! htmlspecialchars($music->catalog_number) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No music found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
