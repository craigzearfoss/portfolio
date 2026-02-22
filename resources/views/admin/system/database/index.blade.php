@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Databases';

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Databases' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $databases->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
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

                @forelse ($databases as $database)

                    <tr data-id="{{ $database->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($database->owner))
                                    @include('admin.components.link', [
                                        'name' => $database->owner->username,
                                        'href' => route('admin.system.admin.show', $database->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $database->name !!}
                        </td>
                        <td data-field="database">
                            {!! $database->database !!}
                        </td>
                        <td data-field="tag">
                            {!! $database->tag !!}
                        </td>
                        <td data-field="title">
                            {!! $database->title !!}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($database->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {!! $database->icon !!}"></i>
                                </span>
                            @else
                            @endif
                        </td>
                        <td data-field="guest" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->guest ])
                        </td>
                        <td data-field="user" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->user ])
                        </td>
                        <td data-field="admin" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->admin ])
                        </td>
                        <td data-field="global" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->global ])
                        </td>
                        <td data-field="sequence" class="has-text-centered">
                            {{ $database->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $database->menu_level }}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $database, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.database.show', $database),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $database, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.database.edit', $database),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $admin->root ? '16' : '15' }}">There are no databases.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $databases->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
