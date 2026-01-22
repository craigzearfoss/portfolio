@php
    $buttons = [];
    if (canCreate('project', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Project', 'href' => route('admin.portfolio.project.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Projects',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $projects->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>language</th>
                <th>year</th>
                <th>repository</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th class="has-text-centered">featured</th>
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
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $project->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $project->name !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->featured ])
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
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->disabled ])
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
                    <td colspan="{{ $admin->root ? '9' : '8' }}">There are no projects.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $projects->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
