@extends('admin.layouts.default', [
    'title' => 'Applications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Applications' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Application', 'url' => route('admin.career.application.create') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
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
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
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
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($applications as $application)

                <tr>
                    @if(isRootAdmin())
                        <td>
                            {{ $application->admin['username'] ?? '' }}
                        </td>
                    @endif
                    <td>
                        {{ $application->role }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->active ])
                    </td>
                    <td class="has-text-centered text-nowrap">
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
                        {{ $application->type }}
                    </td>
                    <td class="text-nowrap">
                        {{ $application->office }}
                    </td>
                    <td>
                        @if ($application->city)
                            {{ $application->city }}@if ($application->state)
                                , {{ $application->state }}
                            @endif
                        @else
                            {{ $application->state }}
                        @endif
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->health ])
                    </td>
                    <td>{{ $application->source }}</td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.application.destroy', $application->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.show', $application->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.edit', $application->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($application->website))
                                <a title="website" class="button is-small px-1 py-0" href="{{ $application->website }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
                                </a>
                            @else
                                <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '17' : '16' }}">There are no applications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $applications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
