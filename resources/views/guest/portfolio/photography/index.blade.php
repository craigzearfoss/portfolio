@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Photography';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title   = $pageTitle ?? filteredPageTitle('photography', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Photography' ],
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

    @include('guest.components.search-panel.portfolio-photography', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($photos->total()) }} {{ ($photos->total() === 1) ? 'photo' : 'photos' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $photos->links('vendor.pagination.bulma') !!}
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
                        <th class="hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'credit',
                                'sort'  => 'credit|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-750">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'photo_year|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($photos as $photo)

                    <tr data-id="{{ $photo->id }}" {!! $video->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($photo->name),
                                'href'  => route('guest.portfolio.photography.show', [$owner, $photo->slug]),
                                'class' => $photo->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.photo', 'data-id' => $photo->id ]
                            ])
                            */ ?>
                        </td>
                        <td class="hide-at-480" style="white-space: nowrap;">
                            {!! htmlspecialchars($photo->credit) !!}
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

            @if (!empty($pagination_bottom))
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
