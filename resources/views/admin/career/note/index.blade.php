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
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Notes' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Notes' ]
        ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Note::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Note', 'href' => route('admin.career.note.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-note', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $notes->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>application</th>
                        <th>subject</th>
                        <th>body</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>application</th>
                        <th>subject</th>
                        <th>body</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($notes as $note)

                    <tr data-id="{{ $note->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $note->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="application_id" style="white-space: nowrap;">
                            @if(!empty($application))
                                @include('admin.components.link', [
                                    'name' => $note->application->name ,
                                    'href' => route('admin.career.application.show',
                                                    Application::find($note->application->id)
                                              )
                                ])
                            @endif
                        </td>
                        <td data-field="subject" style="white-space: nowrap;">
                            {!! $note->subject !!}
                        </td>
                        <td data-field="body">
                            @if(strlen($note->subject) > 200)
                                {!! substr($note->subject, 0, 200) !!}...
                            @else
                                {!! $note->subject !!}
                            @endif
                        </td>
                        <td data-field="created_at" style="white-space: nowrap;">
                            {{ shortDateTime($note->created_at) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($note, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.note.show', $note),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($note, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.note.edit', $note),
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

                                @if(canDelete($note, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.note.destroy', $note) !!}" method="POST">
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
                        @php
                            $colspan = $isRootAdmin ? '6' : '5';
                            if (!empty($application)) $colspan = $colspan++;
                        @endphp
                        <td colspan="{{ $colspan }}">No notes found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $notes->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
