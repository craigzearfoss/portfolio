@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Notes' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
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
    if (canCreate(PermissionEntityTypes::RESOURCE, 'note', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Note', 'href' => route('admin.career.note.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.note.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $notes->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
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

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
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
                @endif

                <tbody>

                @forelse ($notes as $note)

                    <tr data-id="{{ $note->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $note->owner->username ?? '' }}
                            </td>
                        @endif
                        @if(!empty($application))
                            <td data-field="application_id">
                                @include('admin.components.link', [
                                    'name' => $note->application->name ,
                                    'href' => route('admin.career.application.show',
                                                    \App\Models\Career\Application::find($note->application->id)
                                              )
                                ])
                            </td>
                        @endif
                        <td data-field="subject" style="white-space: nowrap;">
                            {!! $note->subject !!}
                        </td>
                        <td data-field="created_at" style="white-space: nowrap;">
                            {{ shortDateTime($note->created_at) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $note, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.note.show', $note),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $note, $admin))
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $note, $admin))
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
                        @php
                            $colspan = $admin->root ? '4' : '3';
                            if (!empty($application)) $colspan = $colspan++;
                        @endphp
                        <td colspan="{{ $colspan }}">There are no notes.</td>
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
