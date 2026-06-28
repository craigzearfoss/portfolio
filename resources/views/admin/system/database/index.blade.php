@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Database';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

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

    @include('admin.components.search-panel.system-database')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 90em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.database.export', request()->except([ 'page' ])),
                'filename' => 'databases_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($databases->total()) }} {{ ($databases->total() === 1) ? 'database' : 'databases' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $databases->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the database is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'id',
                                'sort'  => 'id|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'owner',
                                'sort'  => 'owner_username|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'tag',
                                'sort'  => 'tag|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'database',
                                'sort'  => 'database|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'title',
                                'sort'  => 'title|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'plural',
                                'sort'  => 'plural|asc',
                            ])
                        </th>
                        <th class="has-text-centered">icon</th>
                        <th class="has-text-centered">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'guest',
                                'sort'  => 'guest|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'user',
                                'sort'  => 'user|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'admin',
                                'sort'  => 'admin|desc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'sequence',
                                'sort'  => 'sequence|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'menu',
                                'sort'  => 'menu|desc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
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

                @forelse ($databases as $database)

                    <tr data-id="{{ $database->id }}" {!! $database->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td data-field="id">
                            {{ $database->id }}
                        </td>
                        <td data-field="owner.username" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $database->owner->username,
                                'href' => route('admin.system.admin.show', $database->owner)
                            ])
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $database->name }}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'system.database', 'data-id' => $database->id ]
                           ])
                        </td>
                        <td data-field="tag">
                            {{ $database->tag }}
                        </td>
                        <td data-field="database">
                            {{ $database->database }}
                        </td>
                        <td data-field="title">
                            {{ $database->title }}
                        </td>
                        <td data-field="plural">
                            {{ $database->plural }}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($database->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {{ $database->icon }}"></i>
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
                        <td data-field="sequence" class="has-text-centered">
                            {{ $database->sequence }}
                        </td>
                        <td data-field="menu" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->menu ])
                        </td>
                        <td data-field="menu_level" class="has-text-centered">
                            {{ $database->menu_level }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $database->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($database, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.database.show', $database),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($database, $admin))
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
                        <td colspan="17">No databases found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $databases->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
