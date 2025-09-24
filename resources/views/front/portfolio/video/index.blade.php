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
                            <th>name</th>
                            <th>featured</th>
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
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $video->name,
                                        'url'    => route('front.portfolio.video.show', $video->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $video->$project ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $video->$project ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $video->$project ])
                                </td>
                                <td class="text-nowrap">
                                    {{ shortDate($video->date) }}
                                </td>
                                <td>
                                    {{ $video->year }}
                                </td>
                                <td>
                                    {{ $video->company }}
                                </td>
                                <td>
                                    {{ $video->credit }}
                                </td>
                                <td>
                                    {{ $video->location }}
                                </td>
                                <td>
                                    @include('front.components.link', [ 'url' => $video->link, 'target' => '_blank' ])
                                </td>
                                <td>
                                    {!! nl2br($video->description) !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="11">There are no videos.</td>
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
