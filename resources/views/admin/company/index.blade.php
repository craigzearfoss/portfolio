@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Companies</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.company.create') }}"><i class="fa fa-plus"></i> Add New Company</a>
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

                        @forelse ($companies as $company)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    @if ($company->city)
                                        {{ $company->city }}@if ($company->state), {{ $company->state }}@endif
                                    @else
                                        {{ $company->state }}
                                    @endif
                                </td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ $company->email }}</td>
                                <td>
                                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                </td>
                                <td class="text-center">
                                    @if ($company->disabled)
                                        <i class="fa-solid fa-check ml-2"></i>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.company.show', $company->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.company.edit', $company->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">There are no companies.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $companies->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
