@php
    $title   = $pageTitle ?? $owner->name . ' photography';
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

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>credit</th>
                    <th>year</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>credit</th>
                    <th>year</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($photos as $photo)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $photo->name,
                                'href'  => route('guest.portfolio.photography.show', [$owner, $photo->slug]),
                                'class' => $photo->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            {!! $photo->credit !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $photo->year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="2">There are no photos.</td>
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
