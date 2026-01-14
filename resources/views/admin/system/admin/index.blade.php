@php
    $buttons = [];
    if (canCreate('admin', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'href' => route('admin.admin.create') ];
    }
    if (canRead('admin-team', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Teams', 'href' => route('admin.admin-team.index', $admin) ];
    }
    if (canRead('admin-group', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Groups', 'href' => route('admin.admin-group.index', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Admins',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => adminRoute('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => adminRoute('admin.dashboard') ],
        [ 'name' => 'System',          'href' => adminRoute('admin.index') ],
        [ 'name' => 'Admins' ]
    ],
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
                        {!! $admin->name !!}
                    </td>
                    <td data-field="username">
                        {{ $admin->username }}
                    </td>
                    <td data-field="label">
                        {!! $admin->label !!}
                    </td>
                    <td data-field="admin_team_id">
                        @include('admin.components.link', [
                            'name' => $admin->team->name ?? '',
                            'href' => route('admin.admin-team.show', [$admin, $admin->team->id])
                        ])
                    </td>
                    <td data-field="email">
                        {!! $admin->email !!}
                    </td>
                    <td data-field="phone">
                        {!! \App\Models\System\User::statusName($admin->status) ?? '' !!}
                    </td>
                    <td data-field="root" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->root ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.admin.destroy', $admin->id) !!}" method="POST">

                            @if(canRead($admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.admin.show', $admin->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.admin.edit', $admin->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($admin->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($admin->link_name) ? $admin->link_name : 'link',
                                    'href'   => $admin->link,
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

                            @if(canDelete($admin))
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
                    <td colspan="9">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
