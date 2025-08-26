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
                        <h3 class="card-header ml-3">Show Dictionary Stack</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_stack.edit', $dictionaryStack) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_stack.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'full name',
                                            'value' => $dictionaryStack->full_name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $dictionaryStack->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $dictionaryStack->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'servers',
                                            'value' => implode(', ', $dictionaryStack->servers->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'operating systems',
                                            'value' => implode(', ', $dictionaryStack->operating_systems->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'frameworks',
                                            'value' => implode(', ', $dictionaryStack->frameworks->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'languages',
                                            'value' => implode(', ', $dictionaryStack->languages->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'databases',
                                            'value' => implode(', ', $dictionaryStack->databases->pluck('name')->toArray())
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'website',
                                            'url'    => $dictionaryStack->website,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'wiki page',
                                            'url'    => $dictionaryStack->wiki_page,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $dictionaryStack->description
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
