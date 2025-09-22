@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Music</h3>

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
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($musics as $music)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $music->name,
                                        'url'    => route('front.music.show', $music->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $music->featured ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $music->professional ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $music->personal ])
                                </td>
                                <td>
                                    {!! $music->description !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">There is no music.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $musics->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
