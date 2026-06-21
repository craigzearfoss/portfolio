@php
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
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Databases' : 'Databases' ],
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

            <p><i>{{ number_format($adminDatabases->total()) }} {{ ($adminDatabases->total() === 1) ? 'database' : 'databases' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $adminDatabases->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the admin database is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'id',
                                'sort'  => 'id|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'owner',
                                'sort'  => 'owner_username|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'tag',
                                'sort'  => 'tag|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'database',
                                'sort'  => 'database|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'title',
                                'sort'  => 'title|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'plural',
                                'sort'  => 'plural|asc',
                            ])
                        </th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'guest',
                                'sort'  => 'guest|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'user',
                                'sort'  => 'user|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'admin',
                                'sort'  => 'admin|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'sequence',
                                'sort'  => 'sequence|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'menu',
                                'sort'  => 'menu|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'menu<br>level',
                                'sort'  => 'menu_level|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($adminDatabases as $adminDatabase)

                    <tr data-id="{{ $adminDatabase->id }}" {!! $thisAdmin->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $adminDatabase->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $adminDatabase->$userTeam->username,
                                    'href' => route('admin.system.admin.show', $adminDatabase->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name">
                            {{ $adminDatabase->name }}
                        </td>
                        @if ($isRootAdmin)
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

                                @if (canRead($adminDatabase, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-database.show', $adminDatabase),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($adminDatabase, $admin))
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
                        @if ($isRootAdmin)
                            <td colspan="16">No admin databases found.</td>
                        @else
                            <td colspan="12">No databases found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $adminDatabases->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
