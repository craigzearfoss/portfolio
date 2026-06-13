@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\School';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Schools';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Schools' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <?php /*
    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif
    */ ?>

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
                        <th style="white-space: nowrap;">city</th>
                        <th style="white-space: nowrap;">state</th>
                        <th style="white-space: nowrap;">public/private</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($schools as $school)

                    <tr>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => htmlspecialchars($school->name),
                                'href'  => route('guest.portfolio.school.show', [$school->slug]),
                            ])
                            @if (!empty($school->link))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $school->link,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->city }}
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->state['name'] }}
                        </td>
                        <td data-field="public|private" class="has-text-centered" style="white-space: nowrap;">
                            {{ $school->public ? 'public' : ($school->private ? 'private' : '') }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No schools found.</td>
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
