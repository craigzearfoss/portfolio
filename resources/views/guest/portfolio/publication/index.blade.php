@php
    $title    = $pageTitle ?? $owner->name . ' publications';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Publications' ],
    ];

    // set navigation buttons
    $navButtons = [];
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
                    <th>title</th>
                    <th>publication</th>
                    <?php /* <th>publisher</th> */ ?>
                    <th>year</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>title</th>
                    <th>publication</th>
                    <th>publisher</th>
                    <th>year</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($publications as $publication)

                    <tr data-id="{{ $publication->id }}">
                        <td data-field="title">
                            @include('guest.components.link', [
                                'name'  => $publication->title,
                                'href'  => route('guest.portfolio.publication.show', [$owner, $publication->slug]),
                                'class' => $publication->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="publication_name">
                            {!! $publication->publication_name !!}
                        </td>
                        <?php /*
                        <td data-field="publisher">
                            {!! $publication->publisher !!}
                        </td>
                        */ ?>
                        <td data-field="year" class="has-text-centered">
                            {!! $publication->year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">There are no publications.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $publications->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
