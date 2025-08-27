@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Dictionary Frameworks</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_framework.create') }}"><i
                                        class="fa fa-plus"></i> Add New Dictionary Framework</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>abbreviation</th>
                            <th>owner</th>
                            <th>languages</th>
                            <th>website</th>
                            <th class="text-nowrap">wiki page</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($dictionaryFrameworks as $dictionaryFramework)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dictionaryFramework->name }}</td>
                                <td>{{ $dictionaryFramework->abbreviation }}</td>
                                <td>{{ $dictionaryFramework->owner }}</td>
                                <td>
                                    {{ implode(', ',  $dictionaryFramework->languages->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    @include('admin.components.link', [ 'url' => $dictionaryFramework->website, 'target' => '_blank' ])
                                </td>
                                <td>
                                    @include('admin.components.link', [ 'url' => $dictionaryFramework->wiki_page, 'target' => '_blank' ])
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.dictionary_framework.destroy', $dictionaryFramework->id) }}"
                                          method="POST">
                                        <a class="btn btn-sm"
                                           href="{{ route('admin.dictionary_framework.show', $dictionaryFramework->id) }}"><i
                                                    class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm"
                                           href="{{ route('admin.dictionary_framework.edit', $dictionaryFramework->id) }}"><i
                                                    class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i
                                                    class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">There are no dictionary frameworks.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $dictionaryFrameworks->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
