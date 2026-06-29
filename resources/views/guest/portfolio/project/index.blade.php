@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Project';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('projects', $owner->name);
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

    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-project', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container" style="max-width: 60rem !important;">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($projects->total()) }} {{ ($projects->total() === 1) ? 'project' : 'projects' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}" style="min-width: 30rem; max-width: 70rem; overflow-x: auto; overflow-y: hidden;">

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
                                'name'  => 'language',
                                'sort'  => 'language|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-600">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'project_year|asc',
                            ])
                        </th>
                        <th class="hide-at-1024">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'repository',
                                'sort'  => 'repository_url|asc',
                            ])
                        </th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($projects as $project)

                    <tr data-id="{{ $project->id }}" {{ $project->is_disabled ? 'class="disabled-text"' : '' }}>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $project->name,
                                'href'  => route('guest.portfolio.project.show', [ $project->owner->label, $project->slug ]),
                                'class' => $project->featured ? [ 'has-text-weight-bold' ] : []
                            ])
                            <?php /*
                            @include('guest.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'portfolio.project', 'data-id' => $project->id ]
                            ])
                            */ ?>
                        </td>
                        <td data-field="language" style="white-space: nowrap;">
                            {{ !empty($project->language)
                                ? ($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : ''))
                                : ''
                            }}
                        </td>
                        <td data-field="year" class="has-text-centered hide-at-600">
                            {{ $project->project_year }}
                        </td>
                        <td data-field="year" class="hide-at-1024" style="white-space: nowrap;">
                            @if (!empty($project->repository_url))
                                {{ $project->repository_name ?? $project->repository_url }}
                                @include('guest.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $project->repository_url,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank',
                                    'style'  => [ 'margin-top: -4px' ]
                                ])
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No projects found..</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
