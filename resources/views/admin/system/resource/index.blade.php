@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Resources';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Resources' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $resources->links('vendor.pagination.bulma') !!}
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

                @forelse ($resources as $resource)

                    <tr data-id="{{ $resource->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($resource->owner))
                                    @include('admin.components.link', [
                                        'name' => $resource->owner->username,
                                        'href' => route('admin.system.admin.show', $resource->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="database.name">
                            {!! $resource->database->name ?? '' !!}
                        </td>
                        <td data-field="name">
                            {!! $resource->name !!}
                        </td>
                        <td data-field="table">
                            {!! $resource->table !!}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($resource->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {!! $resource->icon !!}"></i>
                                </span>
                            @else
                            @endif
                        </td>
                        <td data-field="guest" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->guest ])
                        </td>
                        <td data-field="user" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->user ])
                        </td>
                        <td data-field="admin" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->admin ])
                        </td>
                        <td data-field="global" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->global ])
                        </td>
                        <td data-field="sequence" class="has-text-centered">
                            {{ $resource->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $resource->menu_level }}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $resource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.resource.show', $resource),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $resource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.resource.edit', $resource),
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
                {!! $resources->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
