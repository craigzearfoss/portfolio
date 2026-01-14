@php
    $buttons = [];
    if (canCreate('project', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'href' => route('admin.portfolio.project.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Projects',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
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
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
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
            */ ?>
            <tbody>

            @forelse ($projects as $project)
                <tr data-id="{{ $project->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.project.destroy', [$admin, $project->id]) !!}" method="POST">

                            @if(canRead($project))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.project.show', [$admin, $project->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($project))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.project.edit', [$admin, $project->id]),
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

                            @if(canDelete($project))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '9' : '8' }}">There are no projects.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $projects->links('vendor.pagination.bulma') !!}

    </div>

@endsection
