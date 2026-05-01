@php
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\AdminDatabase';
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($owner) ? 'Databases for ' . $owner->name : 'Databases');
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
        [ 'name' => 'Databases' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin-database')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.admin-database.export', request()->except([ 'page' ])),
                'filename' => 'admin_databases_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($adminDatabases->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $adminDatabases->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        @if($isRootAdmin)
                            <th>tag</th>
                            <th>database</th>
                        @endif
                        <th>title</th>
                        <th>plural</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
                        <th class="has-text-centered">sequence</th>
                        <th class="has-text-centered">menu</th>
                        <th class="has-text-centered">menu<br>level</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        @if($isRootAdmin)
                            <th>tag</th>
                            <th>database</th>
                        @endif
                        <th>title</th>
                        <th>plural</th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">guest</th>
                        <th class="has-text-centered">user</th>
                        <th class="has-text-centered">admin</th>
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
                        @if($isRootAdmin)
                            <td data-field="id">
                                {{ $adminDatabase->id ?? '' }}
                            </td>
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
                            {{ $adminDatabase->name }}
                        </td>
                        @if($isRootAdmin)
                            <td data-field="tag">
                                {{ $adminDatabase->tag }}
                            </td>
                            <td data-field="database">
                            {{ $adminDatabase->database }}
                            </td>
                        @endif
                        <td data-field="title">
                            {{ $adminDatabase->title }}
                        </td>
                        <td data-field="plural">
                            {{ $adminDatabase->plural }}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($adminDatabase->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {{ $adminDatabase->icon }}"></i>
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
                        <td data-field="sequence" class="has-text-centered">
                            {{ $adminDatabase->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminDatabase->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $adminDatabase->menu_level }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminDatabase->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminDatabase->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($adminDatabase, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-database.show', $adminDatabase),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($adminDatabase, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-database.edit', $adminDatabase),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        @if($isRootAdmin)
                            <td colspan="16">No admin databases found.</td>
                        @else
                            <td colspan="12">No databases found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $adminDatabases->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
