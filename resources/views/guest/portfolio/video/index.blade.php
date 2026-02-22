@php
    $title    = $pageTitle ?? $owner->name . ' videos';
    $subtitle =- $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Videos' ],
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
                    <th>year</th>
                    <th>show</th>
                    <th>company</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>year</th>
                    <th>show</th>
                    <th>company</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($videos as $video)

                    <tr data-id="{{ $video->id }}">
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name'  => $video->name,
                                'href'  => route('guest.portfolio.video.show', [$owner, $video->slug]),
                                'class' => $video->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="year" class="has-text-centered">
                            {!! $video->year !!}
                        </td>
                        <td data-field="show">
                            {!! $video->show !!}
                        </td>
                        <td data-field="company">
                            {!! $video->company !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">There are no videos.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $videos->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
