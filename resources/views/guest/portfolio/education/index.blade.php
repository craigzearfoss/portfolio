@php
    $title    = $pageTitle ?? filteredPageTitle('education', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
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

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>major</th>
                        <th>degree</th>
                        <th>school</th>
                        <th class="has-text-centered hide-at-480">graduated</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>major</th>
                        <th>degree</th>
                        <th>school</th>
                        <th class="has-text-centered hide-at-480">graduated</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($educations as $education)

                    <tr>
                        <td data-field="major">
                            @if($education->featured)
                                <strong>
                                    {{ $education->major }}
                                    @if(!empty($education->minor)) {
                                        ({{ $education->minor }} minor)
                                    @endif
                                </strong>
                            @else
                                {{ $education->major }}
                                @if(!empty($education->minor)) {
                                    ({{ $education->minor }} minor)
                                @endif
                            @endif
                        </td>
                        <td data-field="degreeType.name">
                            {{ $education->degreeType->name }}
                        </td>
                        <td data-field="school.name">
                            {!! $education->school->name ?? '' !!}
                        </td>
                        <td data-field="graduation_date" class="has-text-centered hide-at-480">
                            {{ $education->graduation_date }}
                            @if(!empty($education->currently_enrolled))
                                (currently enrolled)
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">No education found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $educations->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
