@php
    $title    = $pageTitle ?? $owner->name . ' award';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Award' ],
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
                    <th>name</th>
                    <th>category</th>
                    <th>nominated work</th>
                    <th>year</th>
                    <th>organization</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>category</th>
                    <th>nominated work</th>
                    <th>year</th>
                    <th>organization</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($awards as $award)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $award->name,
                                'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                'class' => $award->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            @if(!empty($award->category))
                                @include('guest.components.link', [
                                    'name'  => $award->category,
                                    'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                                    'class' => $award->featured ? 'has-text-weight-bold' : ''
                                ])
                            @endif
                        </td>
                        <td>
                            {!! $award->nominated_work !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $award->year !!}
                        </td>
                        <td>
                            {!! $award->organization !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">There are no awards.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $awards->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
