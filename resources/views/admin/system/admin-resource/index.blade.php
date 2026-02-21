@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? (!empty($owner) ? $owner->name . ' Resources' : 'Resources');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Resources' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.system.admin-resource.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $adminResources->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>database</th>
                    <th>name</th>
                    <th>table</th>
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
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        <th>database</th>
                        <th>name</th>
                        <th>table</th>
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

                @forelse ($adminResources as $adminResource)

                    <tr data-id="{{ $adminResource->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($adminResource->owner))
                                    @include('admin.components.link', [
                                        'name' => $adminResource->owner->username,
                                        'href' => route('admin.system.admin.show', $adminResource->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="database.name">
                            {!! $adminResource->database->name ?? '' !!}
                        </td>
                        <td data-field="name">
                            {!! $adminResource->name !!}
                        </td>
                        <td data-field="table">
                            {!! $adminResource->table !!}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($adminResource->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {!! $adminResource->icon !!}"></i>
                                </span>
                            @else
                            @endif
                        </td>
                        <td data-field="guest" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->guest ])
                        </td>
                        <td data-field="user" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->user ])
                        </td>
                        <td data-field="admin" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->admin ])
                        </td>
                        <td data-field="global" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->global ])
                        </td>
                        <td data-field="sequence" class="has-text-centered">
                            {{ $adminResource->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $adminResource->menu_level }}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $adminResource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-resource.show',
                                                         isRootAdmin() && !empty($owner)
                                                             ? [ $adminResource, 'owner_id'=>$owner->id ]
                                                             : [ $adminResource ]
                                                        ),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $adminResource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-resource.edit',
                                                         isRootAdmin() && !empty($owner)
                                                             ? [ $adminResource, 'owner_id'=>$owner->id ]
                                                             : [ $adminResource ]
                                                        ),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $admin->root ? '15' : '14' }}">There are no resources.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $adminResources->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
