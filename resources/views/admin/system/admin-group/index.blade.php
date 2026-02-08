@php
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'admin-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Group',
                                                               'href' => route('admin.system.admin-group.create')
                                                             ])->render();
    }
    if (canRead(\App\Enums\PermissionEntityTypes::RESOURCE, 'admin-team', $admin)) {
        $buttons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Teams',
                                                                'href' => route('admin.system.admin-team.index')
                                                              ])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Groups',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admin Groups' ]
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
            {!! $adminGroups->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>team</th>
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
                    <th>team</th>
                    <th>abbreviation</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($adminGroups as $adminGroup)

                <tr data-id="{{ $adminGroup->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            @if(!empty($adminGroup->owner))
                                @include('admin.components.link', [
                                    'name' => 'owner',
                                    'label' => $adminGroup->owner->username,
                                    'href' => route('admin.system.admin.show', $adminGroup->owner)
                                ])
                            @else
                                ?
                            @endif
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $adminGroup->name !!}
                    </td>
                    <td data-field="team.name">
                        @if(!empty($adminGroup->team))
                            @include('admin.components.link', [
                                'name' => $adminGroup->team->name,
                                'href' => route('admin.system.admin-team.show', $adminGroup->owner)
                            ])
                        @else
                            ?
                        @endif
                    </td>
                    <td data-field="abbreviation">
                        {!! $adminGroup->abbreviation !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminGroup->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.admin-group.show', $adminGroup),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.admin-group.edit', $adminGroup),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.admin-group.destroy', $adminGroup) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '6' : '5' }}">There are no admin groups.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $adminGroups->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
