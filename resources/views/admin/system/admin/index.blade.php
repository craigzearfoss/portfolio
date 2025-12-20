@php
    $buttons = [];
    if (canCreate('admin', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'href' => route('admin.system.admin.create') ];
    }
    if (canRead('admin-team', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Teams', 'href' => route('admin.system.admin-team.index') ];
    }
    if (canRead('admin-group', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Groups', 'href' => route('admin.system.admin-group.index') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Admins',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins' ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th style="white-space: nowrap;">user name</th>
                <th>label</th>
                <th>team</th>
                <th>email</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th style="white-space: nowrap;">user name</th>
                <th>label</th>
                <th>team</th>
                <th>email</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($admins as $admin)

                <tr data-id="{{ $admin->id }}">
                    <td data-field="name">
                        {{ $admin->name }}
                    </td>
                    <td data-field="username">
                        {{ $admin->username }}
                    </td>
                    <td data-field="label">
                        {{ $admin->label }}
                    </td>
                    <td data-field="admin_team_id">
                        @include('admin.components.link', [
                            'name' => $admin->team->name,
                            'href' => route('admin.system.admin-team.show', $admin->team->id)
                        ])
                    </td>
                    <td data-field="email">
                        {{ $admin->email }}
                    </td>
                    <td data-field="phone">
                        {{ \App\Models\System\User::statusName($admin->status) }}
                    </td>
                    <td data-field="root" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->root ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.system.admin.destroy', $admin->id) }}" method="POST">

                            @if(canRead($admin))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.admin.show', $admin->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($admin))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.admin.edit', $admin->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($admin->link))
                                <a title="{{ !empty($admin->link_name) ? $admin->$project : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $admin->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($admin))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="9">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
