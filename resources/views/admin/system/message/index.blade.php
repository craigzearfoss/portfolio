@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'message', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Message', 'href' => route('admin.system.message.create', $owner)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Messages',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $messages->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>email</th>
                    <th>subject</th>
                    <th>created at</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($messages as $message)

                <tr data-id="{{ $message->id }}">
                    <td data-field="name">
                        {!! $message->name !!}
                    </td>
                    <td data-field="email">
                        {!! $message->email !!}
                    </td>
                    <td data-field="subject">
                        {!! $message->subject !!}
                    </td>
                    <td data-field="created_at">
                        {{ shortDateTime($message->created_at) }}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $message, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.message.show', $message),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $message, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.message.edit', $message),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $message, $admin))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $message, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.message.destroy', $message) !!}" method="POST">
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
                    <td colspan="5">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $messages->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
