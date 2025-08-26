@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Dictionary Stacks</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.dictionary_stack.create') }}"><i class="fa fa-plus"></i> Add New Dictionary Stack</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>servers</th>
                            <th>operating systems</th>
                            <th>frameworks</th>
                            <th>languages</th>
                            <th>databases</th>
                            <th>website</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($dictionaryStacks as $dictionaryStack)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dictionaryStack->name }}</td>
                                <td>
                                    {{ implode(', ',  $dictionaryStack->servers->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    {{ implode(', ',  $dictionaryStack->operating_systems->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    {{ implode(', ',  $dictionaryStack->frameworks->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    {{ implode(', ',  $dictionaryStack->languages->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    {{ implode(', ',  $dictionaryStack->databases->pluck('name')->toArray()) }}
                                </td>
                                <td>
                                    @include('admin.components.link', [ 'url' => $dictionaryStack->website, 'target' => '_blank' ])
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.dictionary_stack.destroy', $dictionaryStack->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.dictionary_stack.show', $dictionaryStack->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.dictionary_stack.edit', $dictionaryStack->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">There are no dictionary stacks.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $dictionaryStacks->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
