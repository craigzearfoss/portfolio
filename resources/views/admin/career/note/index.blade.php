@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Notes' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Notes' ]
        ];
    }

    $buttons = [];
    if (canCreate('note', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Note', 'href' => route('admin.career.note.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Notes' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(!empty($application))
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
                @if(!empty($application))
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
                            {{ $note->owner->username ?? '' }}
                        </td>
                    @endif
                    @if(!empty($application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $note->application->name ,
                                'href' => route('admin.career.application.show', $note->application->id)
                            ])
                        </td>
                    @endif
                    <td data-field="subject" style="white-space: nowrap;">
                        {!! $note->subject !!}
                    </td>
                    <td data-field="created_at" style="white-space: nowrap;">
                        {{ shortDateTime($note->created_at) }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.note.destroy', $note->id) !!}" method="POST">

                            @if(canRead($note))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.note.show', $note->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($note))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.note.edit', $note->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($note->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($note->link_name) ? $note->link_name : 'link',
                                    'href'   => $note->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete($note))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

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
