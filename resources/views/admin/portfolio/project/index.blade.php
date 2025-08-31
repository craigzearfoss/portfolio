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
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th>year</th>
            <th>repository</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">root</th>
            <th class="text-center">read-only</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th>year</th>
            <th>repository</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">root</th>
            <th class="text-center">read-only</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($projects as $project)

            <tr>
                <td>
                    {{ $project->name }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $project->professional ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $project->personal ])
                </td>
                <td>
                    {{ $project->year }}
                </td>
                <td>
                    @include('admin.components.link', [ 'url' => $project->repository, 'target' => '_blank' ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $project->public ])
                </td>
                <td class="text-center">
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
                <td colspan="11">There are no projects.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $projects->links('vendor.pagination.bulma') !!}

@endsection
