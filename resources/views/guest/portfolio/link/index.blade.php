@php
    $title    = $pageTitle ?? filteredPageTitle('links', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Links' ],
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

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $links->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>url</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>url</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($links as $link)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $link->name,
                                'href'  => route('guest.portfolio.link.show', [$owner, $link->slug]),
                                'class' => $link->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            @include('guest.components.link', [
                                'name'   => $link->url,
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

            @if($pagination_bottom)
                {!! $links->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
