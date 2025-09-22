@extends('admin.layouts.default', [
    'title' => 'Projects',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'url' => route('admin.portfolio.project.create') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th class="text-nowrap">name</th>
                <th class="text-nowrap">language</th>
                <th>year</th>
                <th class="text-nowrap">repository</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th class="text-nowrap">name</th>
                <th class="text-nowrap">language</th>
                <th>year</th>
                <th class="text-nowrap">repository</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($projects as $project)

                <tr>
                    <td class="py-0 text-nowrap">
                        {{ $project->name }}
                    </td>
                    <td class="py-0 text-nowrap">
                        {{ !empty($project->language)
                            ? ($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : ''))
                            : ''
                        }}
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $project->year }}
                    </td>
                    <td class="py-0 text-nowrap">
                        @include('admin.components.link', [
                            'name'   => $project->repository_name,
                            'url'    => $project->repository_url,
                            'target' => '_blank'
                        ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.project.destroy', $project->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.project.show', $project->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.project.edit', $project->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($project->link))
                                <a title="{{ !empty($project->link_name) ? $project->link_name : 'link' }}" class="button is-small px-1 py-0" href="{{ $project->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no projects.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $projects->links('vendor.pagination.bulma') !!}

    </div>

@endsection
