@php
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Team',
                                                               'href' => route('admin.system.admin-team.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(\App\Enums\PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Groups',
                                                                'href' => route('admin.system.admin-group.index')
                                                              ])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Teams',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admin Teams' ]
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
            {!! $adminTeams->links('vendor.pagination.bulma') !!}
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

            @forelse ($adminTeams as $adminTeam)

                <tr data-id="{{ $adminTeam->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            @if(!empty($adminTeam->owner))
                                @include('admin.components.link', [
                                    'name' => $adminTeam->owner->username,
                                    'href' => route('admin.system.admin.show', $adminTeam->owner)
                                ])
                            @else
                                ?
                            @endif
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $adminTeam->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $adminTeam->abbreviation !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminTeam->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $adminTeam, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.admin-team.show', $adminTeam->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $adminTeam, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.admin-team.edit', $adminTeam->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $adminTeam, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.admin-team.destroy', $adminTeam) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '5' : '4' }}">There are no admin teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $adminTeams->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
