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
                        <h3 class="card-header ml-3">Show Dictionary Framework</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow"
                                 role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.dictionary_framework.edit', $dictionaryFramework) }}"><i
                                                    class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.dictionary_framework.index') }}"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'full name',
                                            'value' => $dictionaryFramework->full_name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $dictionaryFramework->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $dictionaryFramework->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'abbreviation',
                                            'value' => $dictionaryFramework->abbreviation
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $dictionaryFramework->owner
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'languages',
                                            'value' => implode(', ', $dictionaryFramework->languages->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'open source',
                                            'checked' => $dictionaryFramework->open_source
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'proprietary',
                                            'checked' => $dictionaryFramework->proprietary
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'compiled',
                                            'checked' => $dictionaryFramework->compiled
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'website',
                                            'url'    => $dictionaryFramework->website,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'wiki page',
                                            'url'    => $dictionaryFramework->wiki_page,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $dictionaryFramework->description
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
