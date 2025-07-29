@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Applications</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.application.create') }}"><i class="fa fa-plus"></i> Add New Application</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>no.</th>
                            <th>role</th>
                            <th class="text-nowrap">apply date</th>
                            <th>duration</th>
                            <th>compensation</th>
                            <th>type</th>
                            <th>location</th>
                            <th>source</th>
                            <th>rating</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($applications as $application)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $application->role }}</td>
                                <td>{{ $application->apply_date }}</td>
                                <td>{{ $application->duration }}</td>
                                <td>{{ $application->compensation }}</td>
                                <td>
                                    {{ $application->type == 0 ? 'onsite' : ($application->type == 1 ? 'remote' : ($application->type == 2 ? 'hybrid' : '?')) }}
                                </td>
                                <td>{{ $application->location }}</td>
                                <td>{{ $application->source }}</td>
                                <td>{{ $application->rating }}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.application.destroy', $application->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.application.show', $application->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.application.edit', $application->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">There are no applications.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $applications->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
