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
                        <h3 class="card-header ml-3">Show Dictionary Language</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_language.edit', $dictionaryLanguage) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_language.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'full name',
                                            'value' => $dictionaryLanguage->full_name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $dictionaryLanguage->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $dictionaryLanguage->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'abbreviation',
                                            'value' => $dictionaryLanguage->abbreviation
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $dictionaryLanguage->owner
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'open source',
                                            'checked' => $dictionaryLanguage->open_source
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'proprietary',
                                            'checked' => $dictionaryLanguage->proprietary
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'compiled',
                                            'checked' => $dictionaryLanguage->compiled
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'website',
                                            'url'    => $dictionaryLanguage->website,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'wiki page',
                                            'url'    => $dictionaryLanguage->wiki_page,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $dictionaryLanguage->description
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
