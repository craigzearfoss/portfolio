@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('videos', $owner->name);
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

    @include('guest.components.search-panel.portfolio-video', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if(!empty($pagination_top))
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered hide-at-480">year</th>
                        <th class="hide-at-600">show</th>
                        <th class="hide-at-1200">company</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered hide-at-480">year</th>
                        <th class="hide-at-600">show</th>
                        <th class="hide-at-1200">company</th>
                    </tr>
                    </tfoot>
                @endif

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
                        <td data-field="year" class="has-text-centered hide-at-480">
                            {!! $video->video_year !!}
                        </td>
                        <td data-field="show" class="hide-at-600">
                            {!! $video->show !!}
                        </td>
                        <td data-field="company" class="hide-at-1200">
                            {!! $video->company !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No videos found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
