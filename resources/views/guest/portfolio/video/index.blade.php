@php
    $title    = $pageTitle ?? $owner->name . ' videos';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Videos' ],
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
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th class="hide-at-360">year</th>
                    <th>show</th>
                    <th class="hide-at-480">company</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th class="hide-at-360">year</th>
                    <th>show</th>
                    <th class="hide-at-480">company</th>
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
                        <td data-field="year" class="has-text-centered hide-at-360">
                            {!! $video->year !!}
                        </td>
                        <td data-field="show">
                            {!! $video->show !!}
                        </td>
                        <td data-field="company" class="hide-at-480">
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

            @if($pagination_bottom)
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
