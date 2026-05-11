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

            @include('admin.components.export-buttons-container')

            <p><i>{{ number_format($backups->total()) }} records found.</i></p>

            @if (!empty($pagination_top))
                {!! $certifictaions->links('vendor.pagination.bulma') !!}
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

                @forelse ($backups as $backup)

                    <tr data-id="{{ $backup->id }}">
                        <td data-field="id">
                            {{ $backup->id }}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $backup->name }}
                        </td>
                        <td data-field="filepath" style="white-space: nowrap;">
                            {{ $backup->filepath }}
                        </td>
                        <td data-field="updated_at" style="white-space: nowrap;">
                            {{ longDateTime($backup->updated_at) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @include('admin.components.link-icon', [
                                    'title'  => 'Download file',
                                    'href'   => route('admin.system.backup.download', $backup),
                                    'icon'   => 'fa-download',
                                    'target' => '_blank'
                                ])

                            @if (canDelete($backup, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.backup.destroy', $backup) !!}" method="POST">
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
                {!! $backups->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
