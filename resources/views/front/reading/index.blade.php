@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Readings</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('front.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>title</th>
                            <th>author</th>
                            <th class="text-center">paper</th>
                            <th class="text-center">audio</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($readings as $reading)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $reading->title }}</td>
                                <td>{{ $reading->author }}</td>
                                <td class="text-center">
                                    @if ($reading->paper)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($reading->audio)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="">There are no readings.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $readings->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
