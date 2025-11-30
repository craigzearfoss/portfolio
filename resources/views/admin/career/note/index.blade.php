@php
$breadcrumbs = [
    [ 'name' => 'Home',            'href' => route('system.index') ],
    [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    [ 'name' => 'Career',          'href' => route('admin.career.index') ],
    [ 'name' => 'Applications' ,   'href' => route('admin.career.application.index') ],
];
if (!empty($application)) {
    $breadcrumbs[] = [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ];
    $breadcrumbs[] = [ 'name' => 'Notes',            'href' => route('admin.career.note.index', ['application_id' => $application->id]) ];

} else {
    $breadcrumbs[] = [ 'name' => 'Notes', 'href' => route('admin.career.note.index') ];
}
@endphp
@extends('admin.layouts.default', [
    'title' => 'Notes',
    'breadcrumbs' => $breadcrumbs,
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New New', 'href' => route('admin.career.note.create', !empty($application) ? ['application_id' => $application->id] : []) ],
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
                <th>created at</th>
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
                <th>created at</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($notes as $note)

                <tr data-id="{{ $note->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $note->owner['username'] ?? '' }}
                        </td>
                    @endif
                    @if(empty($application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $note->application->name,
                                'href' => route('admin.career.application.show', $note->application->id)
                            ])
                        </td>
                    @endif
                    <td data-field="subject" style="white-space: nowrap;">
                        {{ $note->subject }}
                    </td>
                    <td data-field="created_at" style="white-space: nowrap;">
                        {{ shortDateTime($note->created_at) }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.note.destroy', $note->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.note.show', $note->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.note.edit', $note->id) }}">
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
                    $colspan = isRootAdmin() ? '4' : '3';
                    if (!empty($application)) $colspan = $colspan++;
                    @endphp
                    <td colspan="{{ $colspan }}">There are no notes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $notes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
