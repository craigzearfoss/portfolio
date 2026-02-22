@php
    $title    = $pageTitle ?? $owner->name . ' education';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Education' ],
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
                    <th>major</th>
                    <th>degree</th>
                    <th>school</th>
                    <th class="has-text-centered">graduated</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>major</th>
                    <th>degree</th>
                    <th>school</th>
                    <th class="has-text-centered">graduated</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($educations as $education)

                    <tr>
                        <td data-field="major">
                            {{ $education->major }}
                            @if(!empty($education->minor)) {
                                ({{ $education->minor }} minor)
                            @endif
                        </td>
                        <td data-field="degreeType.name">
                            {{ $education->degreeType->name }}
                        </td>
                        <td data-field="school.name">
                            {!! $education->school->name ?? '' !!}
                        </td>
                        <td data-field="graduation_month|graduation_year" class="has-text-centered">
                            {{ $education->graduation_year }}
                            @if(!empty($education->currently_enrolled))
                                (currently enrolled)
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">There is no education.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $educations->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
