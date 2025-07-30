@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Contacts</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.contact.create') }}"><i class="fa fa-plus"></i> Add New Contact</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>location</th>
                            <th>phone</th>
                            <th>email</th>
                            <th>website</th>
                            <th class="text-center">disabled</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($contacts as $contact)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>
                                    @if ($contact->city)
                                        {{ $contact->city }}@if ($contact->state), {{ $contact->state }}@endif
                                    @else
                                        {{ $contact->state }}
                                    @endif
                                </td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>
                                    <a href="{{ $contact->website }}" target="_blank">{{ $contact->website }}</a>
                                </td>
                                <td class="text-center">
                                    @if ($contact->disabled)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.contact.show', $contact->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.contact.edit', $contact->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">There are no contacts.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $contacts->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
