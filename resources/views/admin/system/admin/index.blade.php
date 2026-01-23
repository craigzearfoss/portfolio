@php
    $buttons = [];
    if (canCreate('admin', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Admin', 'href' => route('admin.system.admin.create')])->render();
    }
    if (canRead('admin-team', $admin)) {
        $buttons[] = view('admin.components.nav-button-view', ['name' => 'Admin Teams', 'href' => route('admin.system.admin-team.index')])->render();
    }
    if (canRead('admin-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-view', ['name' => 'Admin Groups', 'href' => route('admin.system.admin-group.index')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admins',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins' ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
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
            {!! $allAdmins->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th style="white-space: nowrap;">user name</th>
                <th>label</th>
                <th>team</th>
                <th>email</th>
                <th class="has-text-centered">verified</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th style="white-space: nowrap;">user name</th>
                    <th>label</th>
                    <th>team</th>
                    <th>email</th>
                    <th class="has-text-centered">verified</th>
                    <th>status</th>
                    <th class="has-text-centered">root</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($allAdmins as $thisAdmin)

                <tr data-id="{{ $thisAdmin->id }}">
                    <td data-field="name">
                        {!! $thisAdmin->name !!}
                    </td>
                    <td data-field="username" style="white-space: nowrap;">
                        {{ $thisAdmin->username }}
                    </td>
                    <td data-field="label" style="white-space: nowrap;">
                        {!! $thisAdmin->label !!}
                    </td>
                    <td data-field="admin_team_id">
                        @if(!empty($admin->team_id))
                            @include('admin.components.link', [
                                'name' => $thisAdmin->team->name ?? '',
                                'href' => route('admin.system.admin-team.show',
                                                [ $thisAdmin, \App\Models\System\AdminTeam::where('id', $thisAdmin->team->id)->first() ]
                                          )
                            ])
                        @endif
                    </td>
                    <td data-field="email" style="white-space: nowrap;">
                        {!! $thisAdmin->email !!}
                    </td>
                    <td data-field="email_verified_at" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $thisUser->email_verified_at ])
                    </td>
                    <td data-field="status">
                        {!! \App\Models\System\User::statusName($thisAdmin->status) ?? '' !!}
                    </td>
                    <td data-field="root" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $thisAdmin->root ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $thisAdmin->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($thisAdmin, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.admin.show', $thisAdmin->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($thisAdmin, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.admin.edit', $thisAdmin),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($thisAdmin->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($thisAdmin->link_name) ? $thisAdmin->link_name : 'link',
                                    'href'   => $thisAdmin->link,
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

                            @if(canDelete($thisAdmin, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.admin.destroy', $thisAdmin) !!}" method="POST">
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
                    <td colspan="10">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $allAdmins->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
