@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\AdminResource';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($owner) ? $owner->name . ' Resources' : 'Resources');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index',
                                                       !empty($owner)
                                                           ? ['owner_id'=>$owner->id]
                                                           : []
                                                      )],
        [ 'name' => 'Resources' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin-resource', [ 'owner_id' => $owner->id ?? null])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $adminResources->links('vendor.pagination.bulma') !!}
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
                        <th>resource</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
                        <th class="has-text-centered">sequence</th>
                        <th class="has-text-centered">menu</th>
                        <th class="has-text-centered">menu<br>level</th>
                        <th class="has-text-centered">public</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">readonly</th>
                        @endif
                        <th class="has-text-centered">disabled</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">demo</th>
                        @endif
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>database</th>
                        <th>resource</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
                        <th class="has-text-centered">sequence</th>
                        <th class="has-text-centered">menu</th>
                        <th class="has-text-centered">menu<br>level</th>
                        <th class="has-text-centered">public</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">readonly</th>
                        @endif
                        <th class="has-text-centered">disabled</th>
                        @if($isRootAdmin)
                            <th class="has-text-centered">demo</th>
                        @endif
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($adminResources as $adminResource)

                    <tr data-id="{{ $adminResource->id }}">
                        @if($isRootAdmin)
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
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $adminResource->name !!}
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
                        <td data-field="sequence" class="has-text-centered">
                            {{ $adminResource->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $adminResource->menu_level }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->is_public ])
                        </td>
                        @if($isRootAdmin)
                            <td data-field="is_readonly" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $adminResource->is_readonly ])
                            </td>
                        @endif
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminResource->is_disabled ])
                        </td>
                        @if($isRootAdmin)
                            <td data-field="is_demo" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $adminResource->is_demo ])
                            </td>
                        @endif
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($adminResource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-resource.show', $adminResource),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($adminResource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-resource.edit', $adminResource),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        @if($isRootAdmin)
                            <td colspan="{{ $isRootAdmin ? '15' : '12' }}">No admin resources found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '15' : '12' }}">No resources found.</td>
                        @endif
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
