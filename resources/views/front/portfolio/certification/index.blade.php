@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Certifications</h3>

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
                            <th>organization</th>
                            <th>received</th>
                            <th>expiration</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($certifications as $certification)

                            <tr>
                                <td>
                                    @include('front.components.link', [
                                        'name' => $certification->name,
                                        'href' => route('front.certification.show', $certification->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('front.components.checkmark', [ 'checked' => $certification->featured ])
                                </td>
                                <td>
                                    {{ $certification->organization }}
                                </td>
                                <td>
                                    {{ shortDate($certification->received) }}
                                </td>
                                <td>
                                    {{ shortDate($certification->expiration) }}
                                </td>
                                <td>
                                    {!! nl2br($certification->description ?? '') !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8">There are no certifications.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $certifications->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
