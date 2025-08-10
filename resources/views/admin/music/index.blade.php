@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Musics</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.music.create') }}"><i class="fa fa-plus"></i> Add New Music</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>slug</th>
                            <th class="text-center">professional</th>
                            <th class="text-center">personal</th>
                            <th>description</th>
                            <th class="text-center">public</th>
                            <th class="text-center">disabled</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($musics as $music)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $music->name }}</td>
                                <td>{{ $music->organization }}</td>
                                <td class="text-nowrap">
                                    {{ shortDate($music->received) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ shortDate($music->expiration) }}
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $music->professional ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $music->personal ])
                                </td>
                                <td>{!! $music->description !!}</td>

                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $music->public ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $music->disabled ])
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.music.destroy', $music->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.music.show', $music->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.music.edit', $music->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There is no music.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $musics->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
