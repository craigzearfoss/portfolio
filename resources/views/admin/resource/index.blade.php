@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Resources</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.resource.create') }}"><i class="fa fa-plus"></i> Add New Resource</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>type</th>
                            <th>name</th>
                            <th>database</th>
                            <th>icon</th>
                            <th>sequence</th>
                            <th class="text-center">public</th>
                            <th class="text-center">disabled</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($resources as $resource)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $resource->type }}</td>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->database['name'] }}</td>
                                <td>
                                    @if (!empty($resource->icon))
                                        <span class="text-xl">
                                            <i class="fa-solid {{ $resource->icon }}"></i>
                                        </span>
                                    @else
                                    @endif
                                </td>
                                <td>{{ $resource->sequence }}</td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $resource->public ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $resource->disabled ])
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.resource.destroy', $resource->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.resource.show', $resource->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.resource.edit', $resource->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">There are no resources.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $resources->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
