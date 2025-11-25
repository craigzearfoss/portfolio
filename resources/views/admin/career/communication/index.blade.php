@php
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications' ,   'href' => route('admin.career.application.index') ],
    ];
    if (!empty($application)) {
        $breadcrumbs[] = [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ];
        $breadcrumbs[] = [ 'name' => 'Communications', 'href' => route('admin.career.communication.index', ['application_id' => $application->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'Communications', 'href' => route('admin.career.communication.index') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title' => 'Communications',
    'breadcrumbs' => $breadcrumbs,
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Communication', 'href' => route('admin.career.communication.create', ['application_id' => $application->id] ?? '') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
                    <th>application</th>
                @endif
                <th>subject</th>
                <th>date</th>
                <th>time</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
                    <th>application</th>
                @endif
                <th>subject</th>
                <th>date</th>
                <th>time</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($communications as $communication)

                <tr data-id="{{ $communication->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $communication->owner['username'] ?? '' }}
                        </td>
                    @endif
                    @if(empty($application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $communication->application->name,
                                'href' => route('admin.career.application.show', $communication->application->id)
                            ])
                        </td>
                    @endif
                    <td data-field="subject" style="white-space: nowrap;">
                        {{ $communication->subject }}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($communication->date) }}
                    </td>
                    <td data-field="time" style="white-space: nowrap;">
                        {{ $communication->time }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.communication.destroy', $communication->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.communication.show', $communication->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.communication.edit', $communication->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    @php
                    $colspan = isRootAdmin() ? '5' : '4';
                    if (!empty($application)) $colspan = $colspan++;
                    @endphp
                    <td colspan="{{ isRootAdmin() ? '5' : '4' }}">There are no communications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $communications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
