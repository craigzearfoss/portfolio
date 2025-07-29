@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Videos</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.video.create') }}"><i class="fa fa-plus"></i> Add New Video</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>no.</th>
                            <th>title</th>
                            <th>year</th>
                            <th>company</th>
                            <th>credit</th>
                            <th>location</th>
                            <th>link</th>
                            <th>description</th>
                            <th class="text-center">disabled</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($videos as $video)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->year }}</td>
                                <td>{{ $video->company }}</td>
                                <td>{{ $video->credit }}</td>
                                <td>{{ $video->location }}</td>
                                <td>
                                    <a href="{{ $video->link }}" target="_blank">{{ $video->link }}</a>
                                </td>
                                <td>{{ $video->description }}</td>
                                <td class="text-center">
                                    @if ($video->disabled)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.video.show', $video->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.video.edit', $video->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">There are no videos.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $videos->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
