@php
    $title    = $pageTitle ?? $owner->name . ' projects';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Projects' ],
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
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings))
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>language</th>
                        <th>year</th>
                        <th class="hide-at-600">repository</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>language</th>
                        <th>year</th>
                        <th class="hide-at-600">repository</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($projects as $project)

                    <tr data-id="{{ $project->id }}">
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name'  => $project->name,
                                'href'  => route('guest.portfolio.project.show', [$project->owner->label, $project->slug]),
                                'class' => $project->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="language">
                            {!! !empty($project->language)
                                ? ($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : ''))
                                : ''
                            !!}
                        </td>
                        <td data-field="year">
                            {!! $project->year !!}
                        </td>
                        <td data-field="year" class="hide-at-600">
                            @if(!empty($project->repository_url))
                                @include('guest.components.link', [
                                    'name'   => $project->repository_name,
                                    'href'   => $project->repository_url,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">There are no projects.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
