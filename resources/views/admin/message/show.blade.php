@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Message</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.message.edit', $message) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.message.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $message->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'email',
                                            'value' => $message->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'subject',
                                            'value' => $message->subject
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'body',
                                            'value' => $message->body
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'personal',
                                            'checked' => $message->personal
                                        ])

                                        @include('admin.components.show-row-message', [
                                            'name'   => 'url',
                                            'url'    => $message->url,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'website',
                                            'value' => $message->website
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $message->description
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'sequence',
                                            'value' => $message->sequence
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'public',
                                            'checked' => $message->public
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'disabled',
                                            'checked' => $message->disabled
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $message->admin['username'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($message->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($message->updated_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($message->deleted_at)
                                        ])

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
