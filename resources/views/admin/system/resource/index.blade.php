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

            <p><i>{{ number_format($resources->total()) }} {{ ($resources->total() === 1) ? 'resource' : 'resources' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $resources->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the resource is disabled.</p>

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
                                'name'  => 'database',
                                'sort'  => 'database_database|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'db tag',
                                'sort'  => 'database_tag|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'table',
                                'sort'  => 'table_name|asc',
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
                        <th class="has-text-centered">read-only</th>
                        <th class="has-text-centered">root</th>
                        <th class="has-text-centered">disabled</th>
                        <th class="has-text-centered">demo</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($resources as $resource)

                    <tr data-id="{{ $resource->id }}" {!! $resource->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $resource->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $resource->owner->username,
                                    'href' => route('admin.system.admin.show', $resource->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="database.database" style="white-space: nowrap;">
                            {{ $resource->database->database ?? '' }}
                        </td>
                        @if ($isRootAdmin)
                            <td data-field="database.tag" style="white-space: nowrap;">
                                {{ $resource->database->tag ?? '' }}
                            </td>
                            <td data-field="table_name" style="white-space: nowrap;">
                                {{ $resource->table_name }}
                                @include('admin.components.link-icon', [
                                   'title'      => 'add to favorites',
                                   'icon'       => 'fa-heart',
                                   'border'     => false,
                                   'target'     => '_blank',
                                   'class'      => 'add-to-favorites',
                                   'attributes' => [ 'data-resource' => 'system.resource', 'data-id' => $resource->id ]
                               ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $resource->name }}
                        </td>
                        <td data-field="title" style="white-space: nowrap;">
                            {{ $resource->title }}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $resource->plural }}
                        </td>
                        <td data-field="icon" class="has-text-centered">
                            @if (!empty($resource->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {{ $resource->icon }}"></i>
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
                        @if ($isRootAdmin)
                            <td data-field="is_readonly" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_readonly ])
                            </td>
                        @endif
                        @if ($isRootAdmin)
                            <td data-field="is_root" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_root ])
                            </td>
                        @endif
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resource->is_disabled ])
                        </td>
                        @if ($isRootAdmin)
                            <td data-field="is_demo" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $resource->is_demo ])
                            </td>
                        @endif
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($resource, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.resource.show', $resource),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($resource, $admin))
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
                        @if ($isRootAdmin)
                            <td colspan="22">No admin resources found.</td>
                        @else
                            <td colspan="15">No resources found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $resources->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
