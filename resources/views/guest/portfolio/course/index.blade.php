@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('courses', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Courses' ],
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

    @include('guest.components.search-panel.portfolio-course', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>academy</th>
                        <th class="hide-at-480">instructor</th>
                        <th style="white-space: nowrap;">completion date</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>academy</th>
                        <th class="hide-at-480">instructor</th>
                        <th style="white-space: nowrap;">completion date</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($courses as $course)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $course->name,
                                'href'  => route('guest.portfolio.course.show', [$owner, $course->slug]),
                                'class' => $course->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if(!empty($course->academy->link))
                                {!! $course->academy->name !!}
                            @else
                                @include('guest.components.link', [
                                    'name'   => $course->academy->name] ?? ''),
                                    'href'   => $course->academy->link ?? '',
                                    'target' => '_blank',
                                ])
                            @endif
                        </td>
                        <td class="hide-at-480" style="white-space: nowrap;">
                            {!! $course->instructor !!}
                        </td>
                        <td style="white-space: nowrap;">
                            {!! longDate($course->completion_date) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No courses found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
