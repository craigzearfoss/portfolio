@extends('admin.layouts.default', [
    'title' => 'Projects',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Projects' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Project', 'href' => route('admin.portfolio.project.create') ],
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
                            {{ $project->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $project->name }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $project->featured ])
                    </td>
                    <td data-field="language">
                        {{ !empty($project->language)
                            ? ($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : ''))
                            : ''
                        }}
                    </td>
                    <td data-field="year">
                        {{ $project->year }}
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
                        <form action="{{ route('admin.portfolio.project.destroy', $project->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.project.show', $project->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.project.edit', $project->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($project->link))
                                <a title="{{ !empty($project->link_name) ? $project->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $project->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- dlete --}}
                            </button>
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
