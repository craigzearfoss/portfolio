@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Projects</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.project.create') }}"><i class="fa fa-plus"></i> Add New Project</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th class="text-center">professional</th>
                            <th class="text-center">personal</th>
                            <th>year</th>
                            <th>repository</th>
                            <th>description</th>
                            <th class="text-center">hidden</th>
                            <th class="text-center">disabled</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $project->name }}</td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $project->professional ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $project->personal ])
                                </td>
                                <td>{{ $project->year }}</td>
                                <td>
                                    @include('admin.components.link', [ 'url' => $project->repository, 'target' => '_blank' ])
                                </td>
                                <td>{{ $project->description }}</td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $project->hidden ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $project->disabled ])
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.project.destroy', $project->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.project.show', $project->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.project.edit', $project->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">There are no projects.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $projects->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
