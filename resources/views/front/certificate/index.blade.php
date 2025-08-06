@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Certificates</h3>

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
                            <th>organization</th>
                            <th>received</th>
                            <th>expiration</th>
                            <th>professional</th>
                            <th>personal</th>
                            <th>description</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($certificates as $certificate)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $certificate->name }}</td>
                                <td>{{ $certificate->organization }}</td>
                                <td class="text-nowrap">
                                    {{ shortDate($certificate->received) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ shortDate($certificate->expiration) }}
                                </td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $certificate->professional ])
                                </td>
                                <td class="text-center">
                                    @include('front.components.checkmark', [ 'checked' => $certificate->personal ])
                                </td>
                                <td>{!! $certificate->description !!}</td>
                                <td class="text-nowrap">
                                    @if ($certificate->link)
                                        <a class="btn btn-sm" href="{{ $certificate->link }}" target="_blank">
                                            <i class="fa-solid fa-external-link"></i>{{-- Download--}}
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There are no certificates.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $certificates->links() !!}

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
