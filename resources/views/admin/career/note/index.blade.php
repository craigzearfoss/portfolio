@php
    use App\Models\Career\Application;
    use App\Models\Career\Note;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Note';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Notes' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications', 'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Notes' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Note::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Note',
                                                                  'href' => route('admin.career.note.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-note', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.note.export', request()->except([ 'page' ])),
                'filename' => 'notes_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($notes->total()) }} {{ ($notes->total() === 1) ? 'note' : 'notes' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $notes->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>application</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'subject',
                                'sort'  => 'subject|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'created at',
                                'sort'  => 'created_at|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($notes as $note)

                    <tr data-id="{{ $note->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $note->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $note->owner->username,
                                    'href' => route('admin.system.admin.show', $note->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="application_id" style="white-space: nowrap;">
                            @if (!empty($note->application))
                                @include('admin.components.link', [
                                    'name' => htmlspecialchars($note->application->name ?? ''),
                                    'href' => route('admin.career.application.show',
                                                    Application::find($note->application->id)
                                              )
                                ])
                            @endif
                        </td>
                        <td data-field="subject" style="white-space: nowrap;">
                            {!! htmlspecialchars($note->subject) !!}
                        </td>
                        <td data-field="created_at" style="white-space: nowrap;">
                            {{ shortDateTime($note->created_at) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($note, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.note.show', ownerParams($note, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($note, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.note.edit', ownerParams($note, request()->input('owner_id'), $admin)),
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

                                @if (canDelete($note, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.note.destroy', $note) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '7' : '5' }}">No notes found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $notes->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
