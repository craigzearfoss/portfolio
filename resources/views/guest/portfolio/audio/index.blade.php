@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('audio', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Audio' ],
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

    @include('guest.components.search-panel.portfolio-audio', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $audios->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th class="hide-at-600">type</th>
                        <th class="hide-at-480">year</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="hide-at-600">type</th>
                        <th class="hide-at-480">year</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($audios as $audio)

                    <tr data-id="{{ $audio->id }}">
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $audio->name,
                                'href'  => route('guest.portfolio.audio.show', [$owner, $audio->slug]),
                                'class' => $audio->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="clip|podcast" class="hide-at-600" style="white-space: nowrap;">
                            @php
                                $types = [];
                                if ($audio->podcast) $types[] = 'podcast';
                                if ($audio->clip) $types[] = 'clip';
                            @endphp
                            {!! implode(', ', $types) !!}
                        </td>
                        <td data-field="year" class="hide-at-480">
                            {!! $audio->audio_year !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">No audio found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $audios->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
