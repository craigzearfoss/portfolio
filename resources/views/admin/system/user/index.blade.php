@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Users';
    $subtitle = $itle;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'user', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New User',
                                                               'href' => route('admin.system.user.create')
                                                             ])->render();
    }
    if (canRead(PermissionEntityTypes::RESOURCE, 'user-team', $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'User Teams',
                                                                'href' => route('admin.system.user-team.index')
                                                              ])->render();
    }
    if (canRead(PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'User Groups',
                                                                'href' => route('admin.system.user-group.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $allUsers->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th style="white-space: nowrap;">user name</th>
                    <th>label</th>
                    <th>team</th>
                    <th>email</th>
                    <th class="has-text-centered">verified</th>
                    <th>status</th>
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
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($allUsers as $thisUser)

                    <tr data-id="{{ $thisUser->id }}">
                        <td data-field="name">
                            {!! $thisUser->name !!}
                        </td>
                        <td data-field="username" style="white-space: nowrap;">
                            {{ $thisUser->username }}
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {!! $thisUser->label !!}
                        </td>
                        <td data-field="user_team_id">
                            @if(!empty($thisUser->team_id))
                                @include('admin.components.link', [
                                    'name' => $thisUser->team->name ?? '',
                                    'href' => route('admin.system.user-team.show',
                                                    [ $thisUser, \App\Models\System\UserTeam::where('id', $thisUser->team->id)->first() ]
                                              )
                                ])
                            @endif
                        </td>
                        <td data-field="email" style="white-space: nowrap;">
                            {!! $thisUser->email !!}
                        </td>
                        <td data-field="email_verified_at" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $thisUser->email_verified_at ])
                        </td>
                        <td data-field="status">
                            {!! \App\Models\System\User::statusName($thisUser->status) ?? '' !!}
                        </td>
                        <td data-field=disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $thisUser->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $thisUser, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user.show', $thisUser),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $thisUser, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user.edit', $thisUser),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($thisUser->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($thisUser->link_name) ? $thisUser->link_name : 'link',
                                        'href'   => $thisUser->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $thisUser, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.user.destroy', $thisUser) !!}" method="POST">
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
                        <td colspan="9">There are no users.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $allUsers->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
