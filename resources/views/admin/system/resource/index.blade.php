@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Resource';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

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

    @include('admin.components.search-panel.system-resource', [ 'owner_id' => $owner->id ?? null])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.resource.export', request()->except([ 'page' ])),
                'filename' => 'resources_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $resources->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>database</th>
                        <th>name</th>
                        <th>table</th>
                        <th>title</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
                        <th class="has-text-centered">sequence</th>
                        <th class="has-text-centered">menu</th>
                        <th class="has-text-centered">menu<br>level</th>
                        <th class="has-text-centered">public</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">read-only</th>
                        @endif
                        @if($isRootAdmin)
                            <th class="has-text-centered">root</th>
                        @endif
                        <th class="has-text-centered">disabled</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">demo</th>
                        @endif
                        <th class="has-text-centered">sequence</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin))
                            <th>owner</th>
                        @endif
                        <th>database</th>
                        <th>name</th>
                        <th>table</th>
                        <th>title</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
                        <th class="has-text-centered">sequence</th>
                        <th class="has-text-centered">menu</th>
                        <th class="has-text-centered">menu<br>level</th>
                        <th class="has-text-centered">public</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">read-only</th>
                        @endif
                        @if($isRootAdmin)
                            <th class="has-text-centered">root</th>
                        @endif
                        <th class="has-text-centered">disabled</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">demo</th>
                        @endif
                        <th class="has-text-centered">sequence</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($resources as $resource)

                    <tr data-id="{{ $resource->id }}">
                        @if($isRootAdmin)
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
                        <td data-field="database.name" style="white-space: nowrap;">
                            {!! $resource->database->name ?? '' !!}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $resource->name !!}
                        </td>
                        <td data-field="table" style="white-space: nowrap;">
                            {!! $resource->table_name !!}
                        </td>
                        <td data-field="title" style="white-space: nowrap;">
                            {!! $resource->title !!}
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
                        <td data-field="sequence" class="has-text-centered">
                            {{ $resource->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $resource->menu_level }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->is_public ])
                        </td>
                        @if($isRootAdmin)
                            <td data-field="is_readonly" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_readonly ])
                            </td>
                        @endif
                        @if($isRootAdmin)
                            <td data-field="is_root" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_root ])
                            </td>
                        @endif
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->is_disabled ])
                        </td>
                        @if($isRootAdmin)
                            <td data-field="is_demo" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_demo ])
                            </td>
                        @endif
                        <td data-field="sequence" class="has-text-centered">
                            {{ $resource->sequence }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($resource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.resource.show', $resource),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($resource, $admin))
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
                        @if($isRootAdmin)
                            <td colspan="19">No admin resources found.</td>
                        @else
                            <td colspan="15">No resources found.</td>
                        @endif
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
