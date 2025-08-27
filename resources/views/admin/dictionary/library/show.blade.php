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
                        <h3 class="card-header ml-3">Show Dictionary Library</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow"
                                 role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.dictionary_library.edit', $dictionaryLibrary) }}"><i
                                                    class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm"
                                           href="{{ route('admin.dictionary_library.index') }}"><i
                                                    class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'full name',
                                            'value' => $dictionaryLibrary->full_name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $dictionaryLibrary->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $dictionaryLibrary->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'abbreviation',
                                            'value' => $dictionaryLibrary->abbreviation
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $dictionaryLibrary->owner
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'languages',
                                            'value' => implode(', ', $dictionaryLibrary->languages->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'open source',
                                            'checked' => $dictionaryLibrary->open_source
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'proprietary',
                                            'checked' => $dictionaryLibrary->proprietary
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'compiled',
                                            'checked' => $dictionaryLibrary->compiled
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'website',
                                            'url'    => $dictionaryLibrary->website,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'wiki page',
                                            'url'    => $dictionaryLibrary->wiki_page,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $dictionaryLibrary->description
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
