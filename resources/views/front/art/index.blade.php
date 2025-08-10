@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Art</h3>

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
                            <th>description</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($arts as $art)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $art->name }}</td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $art->professional ])
                                </td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $art->personal ])
                                </td>
                                <td>{!! $art->description !!}</td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm" href="{{ route('art.show', $art->slug) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                    @if ($art->link)
                                        <a class="btn btn-sm" href="{{ $art->link }}" target="_blank">
                                            <i class="fa-solid fa-external-link"></i>{{-- Download--}}
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There is no art.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $arts->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
