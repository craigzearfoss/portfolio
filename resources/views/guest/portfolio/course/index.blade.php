@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Course';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('courses', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Courses' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-course', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($courses->total()) }} {{ ($courses->total() === 1) ? 'course' : 'courses' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'academy',
                                'sort'  => 'academy_name|asc',
                            ])
                        </th>
                        <th class="hide-at-480">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'instructor',
                                'sort'  => 'instructor|asc',
                            ])
                        </th>
                        <th style="white-space: nowrap;">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'completion date',
                                'sort'  => 'completion_date|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($courses as $course)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($course->name),
                                'href'  => route('guest.portfolio.course.show', [$owner, $course->slug]),
                                'class' => $course->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if (!empty($course->academy->link))
                                {!! htmlspecialchars($course->academy->name) !!}
                            @else
                                @include('guest.components.link', [
                                    'name'   => htmlspecialchars($course->academy->name ?? ''),
                                    'href'   => $course->academy->link ?? '',
                                    'target' => '_blank',
                                ])
                            @endif
                        </td>
                        <td class="hide-at-480" style="white-space: nowrap;">
                            {!! htmlspecialchars($course->instructor) !!}
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

            @if (!empty($pagination_bottom))
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
