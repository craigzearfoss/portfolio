@php
    use App\Models\Portfolio\Project;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Projects';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Projects' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Project::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Project', 'href' => route('admin.portfolio.project.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-project', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $projects->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured project.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>language</th>
                        <th>year</th>
                        <th>repository</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>language</th>
                        <th>year</th>
                        <th>repository</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($projects as $project)
                    <tr data-id="{{ $project->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $project->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $project->name !!}{!! !empty($project->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="language">
                            {!! !empty($project->language)
                                ? $project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : '')
                                : ''
                            !!}
                        </td>
                        <td data-field="year">
                            {!! $project->year !!}
                        </td>
                        <td data-field="repository_url">
                            @if(!empty($project->repository_url))
                                @include('admin.components.link', [
                                    'name'   => $project->repository_name ?? '',
                                    'href'   => $project->repository_url,
                                    'target' => '_blank'
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

                                @if(canRead($project, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.project.show', $project),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($project, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.project.edit', $project),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($project->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($project->link_name) ? $project->link_name : 'link',
                                        'href'   => $project->link,
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

                                @if(canDelete($project, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.project.destroy', $project) !!}"
                                          method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '8' : '7' }}">No projects found.</td>
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
