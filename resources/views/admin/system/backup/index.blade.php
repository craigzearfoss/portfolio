@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Settings';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $envSettings = $envSettings ?? null;

    $title    = $pageTitle ?? 'Settings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Settings' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">
                        <ul>

                            <li id="initial-selected-tab" class="is-active" data-target="database-backups">
                                <a>Database</a>
                            </li>
                            <li data-target="image-file-backups">
                                <a>Image Files</a>
                            </li>

                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="database-backups">

                            <h2 class="subtitle mt-4">Database Backups</h2>

                            <p><i>{{ number_format($databaseBackups->total()) }} records found.</i></p>

                            @if (!empty($pagination_top))
                                {!! $databaseBackups->links('vendor.pagination.bulma') !!}
                            @endif

                            <p class="admin-table-caption"></p>

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
                                                'name'  => 'name',
                                                'sort'  => 'name|asc',
                                            ])
                                        </th>
                                        <th>
                                            @include('guest.components.column-heading', [
                                                'class' => $className,
                                                'name'  => 'file',
                                                'sort'  => 'filepath|asc',
                                            ])
                                        </th>
                                        <th>
                                            @include('guest.components.column-heading', [
                                                'class' => $className,
                                                'name'  => 'datetime',
                                                'sort'  => 'updated_at|asc',
                                            ])
                                        </th>
                                        <th>actions</th>
                                    </tr>
                            </{{ $labelElem }}>

                            @endforeach

                            <tbody>

                            @forelse ($databaseBackups as $databaseBackup)

                                <tr data-id="{{ $databaseBackup->id }}">
                                    <td data-field="id">
                                        {{ $databaseBackup->id }}
                                    </td>
                                    <td data-field="name" style="white-space: nowrap;">
                                        {{ $databaseBackup->name }}
                                    </td>
                                    <td data-field="filepath" style="white-space: nowrap;">
                                        {{ $databaseBackup->filepath }}
                                    </td>
                                    <td data-field="updated_at" style="white-space: nowrap;">
                                        {{ longDateTime($databaseBackup->updated_at) }}
                                    </td>
                                    <td class="is-1">

                                        <div class="action-button-panel">

                                            @include('admin.components.link-icon', [
                                                'title'  => 'Download file',
                                                'href'   => route('admin.system.backup.download', $databaseBackup),
                                                'icon'   => 'fa-download',
                                                'target' => '_blank'
                                            ])

                                            @if (canDelete($databaseBackup, $admin))
                                                <form class="delete-resource" action="{!! route('admin.system.backup.destroy', $databaseBackup) !!}" method="POST">
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
                                    <td colspan="5">No backups found.</td>
                                </tr>

                            @endforelse

                            </tbody>

                            </table>

                            @if (!empty($pagination_bottom))
                                {!! $databaseBackups->links('vendor.pagination.bulma') !!}
                            @endif

                        </div>

                        <div id="image-file-backups">

                            <h2 class="subtitle mt-4">Image File Backups</h2>

                            <p><i>{{ number_format(count($imageFileBackups)) }} records found.</i></p>

                            <p class="admin-table-caption"></p>

                            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                                @php
                                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                                @endphp

                                @foreach ($labelElems as $labelElem)

                                    <{{ $labelElem }}>
                                    <tr>
                                        <th>directory</th>
                                        <th>actions</th>
                                    </tr>
                            </{{ $labelElem }}>

                            @endforeach

                            <tbody>

                            @forelse ($imageFileBackups as $imageFileBackupDirectory)

                                <tr data-file="{{ $imageFileBackupDirectory }}">
                                    <td data-field="name" style="white-space: nowrap;">
                                        {{ $imageFileBackupDirectory }}
                                    </td>
                                    <td class="is-1">

                                        <div class="action-button-panel">

                                        </div>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5">No backups found.</td>
                                </tr>

                            @endforelse

                            </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
