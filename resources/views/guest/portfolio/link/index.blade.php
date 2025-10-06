@extends('guest.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('guest.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('guest.components.header')

                @include('guest.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Links</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('guest.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>featured</th>
                            <th>link</th>
                            <th>website</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($links as $link)

                            <tr>
                                <td>
                                    @include('guest.components.link', [
                                        'name' => $link->name,
                                        'href'  => route('guest.portfolio.link.show', $link->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('guest.components.checkmark', [ 'checked' => $link->featured ])
                                </td>
                                <td>
                                    @include('guest.components.link', [
                                        'name'   => $link->name ?? $link->url,
                                        'href'   => $link->url,
                                        'target' => '_blank'
                                    ])
                                </td>
                                <td>
                                    {{ $link->website }}
                                </td>
                                <td>
                                    {!! nl2br($link->description ?? '') !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7">There are no links.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $links->links() !!}

                    @include('guest.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
