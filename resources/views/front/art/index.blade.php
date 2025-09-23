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
                            <th>name</th>
                            <th>featured</th>
                            <th>professional</th>
                            <th>personal</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($arts as $art)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name'   => $art->name,
                                        'url'    => route('front.art.show', $art->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $art->featured ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $art->professional ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $art->personal ])
                                </td>
                                <td>
                                    {!! nl2br($art->description) !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">There is no art.</td>
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
