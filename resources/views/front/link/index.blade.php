@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Links</h3>

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
                            <th>url</th>
                            <th>website</th>
                            <th>description</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($links as $link)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $link->name }}</td>
                                <td class="text-center">
                                    @if ($link->professional)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($link->personal)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a>
                                </td>
                                <td>{{ $link->website }}</td>
                                <td>{{ $link->description }}</td>
                                <td class="text-nowrap"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There are no links.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $links->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
