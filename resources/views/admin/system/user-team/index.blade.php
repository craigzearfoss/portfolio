@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Teams' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New User Team',
                                                               'href' => route('admin.system.user-team.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(\App\Enums\PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-view', [ 'name' => 'User Groups',
                                                                'href' => route('admin.system.user-group.index')
                                                              ])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'User Teams',
    'breadcrumbs'      => $breadcrumbs,
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
            {!! $userTeams->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>abbreviation</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($userTeams as $userTeam)

                <tr data-id="{{ $userTeam->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $userTeam->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $userTeam->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $userTeam->abbreviation ?? '' !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userTeam->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $userTeam, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.user-team.show', $userTeam->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $userTeam, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.user-team.edit', $userTeam->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($userTeam->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($userTeam->link_name) ? $userTeam->link_name : 'link',
                                    'href'   => $userTeam->link,
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $userTeam, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.user-team.destroy', $userTeam) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '5' : '4' }}">There are no user teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $userTeams->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
