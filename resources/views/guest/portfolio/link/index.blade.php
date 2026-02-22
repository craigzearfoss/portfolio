@php
    $title    = $pageTitle ?? $owner->name . ' links';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Links' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>url</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>url</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
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
                        <td colspan="2">There are no links.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $links->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
