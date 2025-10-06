@extends('guest.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('guest.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('guest.components.header')

                @include('guest.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Video</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('guest.portfolio.video.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('guest.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $video->name
                                        ])

                                        @include('guest.components.show-row', [
                                            'name'  => 'year',
                                            'value' => $video->year
                                        ])

                                        @include('guest.components.show-row', [
                                            'name'  => 'company',
                                            'value' => $video->company
                                        ])

                                        @include('guest.components.show-row', [
                                            'name'  => 'credit',
                                            'value' => $video->credit
                                        ])

                                        @include('guest.components.show-row-link', [
                                            'name'   => 'link',
                                            'href'   => $video->link,
                                            'target' => '_blank'
                                        ])

                                        @include('guest.components.show-row', [
                                            'name'  => 'description',
                                            'value' => nl2br($video->description ?? '')
                                        ])

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('guest.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
