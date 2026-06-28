@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Link';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('links', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Links' ],
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

    @include('guest.components.search-panel.portfolio-link', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($links->total()) }} {{ ($links->total() === 1) ? 'link' : 'links' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $links->links('vendor.pagination.bulma') !!}
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
                                'name'  => 'url',
                                'sort'  => 'url|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($links as $link)

                    <tr data-id="{{ $link->id }}" {!! $link->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($link->name),
                                'href'  => route('guest.portfolio.link.show', [$owner, $link->slug]),
                                'class' => $link->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.link', 'data-id' => $link->id ]
                            ])
                            */ ?>
                        </td>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'   => htmlspecialchars($link->url),
                                'href'   => $link->url,
                                'target' => '_blank',
                            ])
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="2">No links found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $links->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
