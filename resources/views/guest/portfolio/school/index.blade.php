@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\School';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('schools', htmlspecialchars($owner->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'School' ],
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

    @include('guest.components.search-panel.portfolio-school', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 50rem;">

            <p><i>{{ number_format($schools->total()) }} {{ ($schools->total() === 1) ? 'school' : 'schools' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th style="white-space: nowrap;">name</th>
                        <th style="white-space: nowrap;">state</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($schools as $school)

                    <tr>
                        <td data-field="name" style="white-space: nowrap;">
                            <?php /*
                            @include('admin.components.link', [
                                'name' => $school->name,
                                'href' => route('admin.portfolio.school.show', $school)
                            ])
                            */ ?>
                            {{ $school->name }}
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->state_name }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No schools found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
