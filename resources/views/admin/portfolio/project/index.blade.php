@php
    use App\Models\Portfolio\Project;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Project';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Projects';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Projects' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Project::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Project',
                                                                  'href' => route('admin.portfolio.project.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-project', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 90em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.project.export', request()->except([ 'page' ])),
                'filename' => 'projects_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($projects->total()) }} {{ ($projects->total() === 1) ? 'project' : 'projects' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured project. <span class="sample-color-box-light-gray"></span> indicates the project is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'language',
                                'sort'  => 'language|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'project_year|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'repository',
                                'sort'  => 'repository|asc',
                            ])
                        </th>
                        <th>public</th>
                        <th>disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($projects as $project)
                    <tr data-id="{{ $project->id }}" {!! $project->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $project->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $project->owner->username,
                                    'href'  => route('admin.system.admin.show', $project->owner),
                                    'class' => $project->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $project->name . (!empty($project->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href'  => route('admin.portfolio.project.show', $project),
                                'class' => $project->is_disabled ? [ 'disabled-text' ] : []
                            ])
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'portfolio.project', 'data-id' => $project->id ]
                           ])
                        </td>
                        <td data-field="language" style="white-space: nowrap;">
                            {{ !empty($project->language)
                                ? $project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : '')
                                : ''
                            }}
                        </td>
                        <td data-field="project_year">
                            {{ $project->project_year }}
                        </td>
                        <td data-field="repository_url" style="white-space: nowrap;">
                            @if (!empty($project->repository_url))
                                @include('admin.components.link', [
                                    'name'   => $project->repository_name ?? '',
                                    'href'   => $project->repository_url,
                                    'target' => '_blank',
                                    'class'  => $project->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            @endif
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $project->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $project->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($project, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.project.show', ownerParams($project, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($project, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.project.edit', ownerParams($project, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($project->repository_url))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($project->repository_url) ? $project->repository_url : 'link',
                                        'href'   => $project->repository_url,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if (canDelete($project, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.project.destroy', $project) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No projects found.</td>
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
