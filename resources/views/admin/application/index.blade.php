@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Applications</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        @if (!$readonly)
                            <div>
                                <a class="btn btn-solid btn-sm" href="{{ route('admin.application.create') }}"><i class="fa fa-plus"></i> Add New Application</a>
                            </div>
                        @endif
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>role</th>
                            <th>active</th>
                            <th>rating</th>
                            <th class="text-nowrap">apply date</th>
                            <th>duration</th>
                            <th>compensation</th>
                            <th>type</th>
                            <th>office</th>
                            <th>location</th>
                            <th>w2</th>
                            <th>relo</th>
                            <th>ben</th>
                            <th>vac</th>
                            <th>health</th>
                            <th>source</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($applications as $application)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $application->role }}</td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->active ])
                                </td>
                                <td class="text-center text-nowrap">
                                    @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                                </td>
                                <td class="text-nowrap">
                                    {{ shortDate($application->apply_date) }}
                                </td>
                                <td>{{ $application->duration }}</td>
                                <td class="text-nowrap">
                                    @if ($application->compensation)
                                        {{ explode('.', Number::currency($application->compensation))[0] }}
                                        @if ($application->compensation_unit)
                                            / {{ $application->compensation_unit }}
                                        @endif
                                    @else
                                        ?
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    {{ $application->type == 0 ? 'perm' : ($application->type == 1 ? 'cont' : ($application->type == 2 ? 'c-t-h' : ($application->type == 3 ? 'proj' : '?'))) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $application->office == 0 ? 'onsite' : ($application->office == 1 ? 'remote' : ($application->office == 2 ? 'hybrid' : '?')) }}
                                </td>
                                <td>
                                    @if ($application->city)
                                        {{ $application->city }}@if ($application->state), {{ $application->state }}@endif
                                    @else
                                        {{ $application->state }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                                </td>
                                <td class="text-center">
                                    @include('admin.components.checkmark', [ 'checked' => $application->health ])
                                </td>
                                <td>{{ $application->source }}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.application.destroy', $application->id) }}" method="POST">
                                        @csrf
                                        <a class="btn btn-sm" href="{{ route('admin.application.show', $application->id) }}"><i class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        @if (!$readonly)
                                            <a class="btn btn-sm" href="{{ route('admin.application.edit', $application->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"><i class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18">There are no applications.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $applications->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
