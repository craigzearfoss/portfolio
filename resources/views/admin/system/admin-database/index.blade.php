@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (isRootAdmin() && !empty($owner)) {
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
    }
    $breadcrumbs[] = [ 'name' => 'Databases' ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? 'Databases for ' . $owner->name : 'Databases'),
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
            {!! $adminDatabases->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th class="has-text-centered">icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">global</th>
                <th class="has-text-centered">sequence</th>
                <th class="has-text-centered">menu</th>
                <th class="has-text-centered">menu<br>level</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root)))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>database</th>
                    <th>tag</th>
                    <th>title</th>
                    <th class="has-text-centered">icon</th>
                    <th class="has-text-centered">guest</th>
                    <th class="has-text-centered">user</th>
                    <th class="has-text-centered">admin</th>
                    <th class="has-text-centered">global</th>
                    <th class="has-text-centered">sequence</th>
                    <th class="has-text-centered">menu</th>
                    <th class="has-text-centered">menu<br>level</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($adminDatabases as $adminDatabase)

                <tr data-id="{{ $adminDatabase->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            @if(!empty($adminDatabase->owner))
                                @include('admin.components.link', [
                                    'name' => $adminDatabase->owner->username,
                                    'href' => route('admin.system.admin-database.show', $adminDatabase->owner)
                                ])
                            @else
                                ?
                            @endif
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $adminDatabase->name !!}
                    </td>
                    <td data-field="database">
                        {!! $adminDatabase->database !!}
                    </td>
                    <td data-field="tag">
                        {!! $adminDatabase->tag !!}
                    </td>
                    <td data-field="title">
                        {!! $adminDatabase->title !!}
                    </td>
                    <td data-field="icon" class="has-text-centered">
                        @if (!empty($adminDatabase->icon))
                            <span class="text-xl">
                                <i class="fa-solid {!! $adminDatabase->icon !!}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td data-field="guest" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->guest ])
                    </td>
                    <td data-field="user" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->user ])
                    </td>
                    <td data-field="admin" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->admin ])
                    </td>
                    <td data-field="global" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->global ])
                    </td>
                    <td data-field="sequence" class="has-text-centered">
                        {{ $adminDatabase->sequence }}
                    </td>
                    <td data-field="menu" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->menu ])
                    </td>
                    <td data-field="menu_level" class="has-text-centered">
                        {{ $adminDatabase->menu_level }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminDatabase->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $adminDatabase, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.admin-database.show',
                                                     isRootAdmin() && !empty($owner)
                                                         ? [ $adminDatabase, 'owner_id'=>$owner->id ]
                                                         : [ $adminDatabase ]
                                                    ),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $adminDatabase, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.admin-database.edit',
                                                     isRootAdmin() && !empty($owner)
                                                         ? [ $adminDatabase, 'owner_id'=>$owner->id ]
                                                         : [ $adminDatabase ]
                                                    ),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ $admin->root ? '16' : '15' }}">There are no admin databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $adminDatabases->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
