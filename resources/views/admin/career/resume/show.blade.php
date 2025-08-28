@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Resume</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow"
                                 role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.career.resume.edit', $resume) }}"><i
                                                    class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.career.resume.index') }}"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $resume->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $resume->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'date',
                                            'value' => longDate($resume->date)
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'   => 'link',
                                            'url'    => $resume->link,
                                            'target' => 'blank'
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'   => 'alt link',
                                            'url'    => $resume->alt_link,
                                            'target' => 'blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $resume->description
                                        ])
                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'primary',
                                            'checked' => $resume->primary
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'public',
                                            'checked' => $resume->public
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'disabled',
                                            'checked' => $resume->disabled
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $resume->admin['username'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($resume->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($resume->updated_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($resume->deleted_at)
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
