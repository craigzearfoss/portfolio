@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Message';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Messages';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages' ],
    ];

    // set navigation buttons
    $navButtons = [];
    /*
    // messages must be created from the site contact pages
    if (canCreate(Message::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Message', 'href' => route('admin.system.message.create', $owner)])->render();
    }
    */
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-message')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.message.export', request()->except([ 'page' ])),
                'filename' => 'messages_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $allMessages->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th class="has-text-centered"><span title="Was the message sent from the admin area?">admin</span></th>
                        <th>name</th>
                        <th>email</th>
                        <th>subject</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th class="has-text-centered"><span title="Was the message sent from the admin area?">admin</span></th>
                        <th>name</th>
                        <th>email</th>
                        <th>subject</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($allMessages as $thisMessage)

                    <tr data-id="{{ $thisMessage->id }}">
                        <td class="has-text-centered" data-field="from_admin">
                            @include('admin.components.checkmark', [ 'checked' => $thisMessage->from_admin ])
                        </td>
                        <td data-field="name">
                            {!! $thisMessage->name !!}
                        </td>
                        <td data-field="email">
                            {!! $thisMessage->email !!}
                        </td>
                        <td data-field="subject">
                            {!! $thisMessage->subject !!}
                        </td>
                        <td data-field="created_at" style="white-space: nowrap;">
                            {{ shortDateTime($thisMessage->created_at) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($thisMessage, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.message.show', $thisMessage),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                <?php /*
                                // you can't delete messages
                                @if(canUpdate($thisMessage, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.message.edit', $thisMessage),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($thisMessage, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.message.destroy', $thisMessage) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif
                                */ ?>

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">No messages found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $allMessages->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
