@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Videos</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>professional</th>
                            <th>personal</th>
                            <th>date</th>
                            <th>year</th>
                            <th>company</th>
                            <th>credit</th>
                            <th>location</th>
                            <th>link</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($videos as $video)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $video->name }}</td>
                                <td class="text-center">
                                    @if ($video->professional)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($video->personal)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $video->date }}</td>
                                <td>{{ $video->year }}</td>
                                <td>{{ $video->company }}</td>
                                <td>{{ $video->credit }}</td>
                                <td>{{ $video->location }}</td>
                                <td>
                                    @if ($video->link)
                                        <a href="{{ $video->link }}" target="_blank">{{ $video->link }}</a>
                                    @endif
                                </td>
                                <td>{{ $video->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">There are no videos.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $videos->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
