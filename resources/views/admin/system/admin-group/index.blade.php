@php
    use App\Models\System\AdminGroup;
    use App\Models\System\AdminTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\AdminGroup';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? $isRootAdmin ? 'Admin Groups' : 'Groups';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Groups' : 'Groups' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => $isRootAdmin ? 'Create New Admin Group' : 'Create New Group',
                                                                  'href' => route('admin.system.admin-group.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    if (canRead(AdminTeam::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => $isRootAdmin ? 'Admin Teams' : 'Teams',
                                                                   'href' => route('admin.system.admin-team.index')
                                                                 ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin-group')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.admin-group.export', request()->except([ 'page' ])),
                'filename' => 'admin_groups_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($adminGroups->total()) }} records found.</i></p>

            @if (!empty($pagination_top))
                {!! $adminGroups->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
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
                        @endif
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
                                'name'  => 'team',
                                'sort'  => 'user_team_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'abbreviation',
                                'sort'  => 'abbreviation|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($adminGroups as $adminGroup)

                    <tr data-id="{{ $adminGroup->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $adminGroup->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if (!empty($adminGroup->owner))
                                    @include('admin.components.link', [
                                        'name' => 'owner',
                                        'label' => $adminGroup->owner->username,
                                        'href' => route('admin.system.admin.show', $adminGroup->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $adminGroup->name }}
                        </td>
                        <td data-field="team.name" style="white-space: nowrap;">
                            @if (!empty($adminGroup->team))
                                @include('admin.components.link', [
                                    'name' => $adminGroup->team->name,
                                    'href' => route('admin.system.admin-team.show', $adminGroup->owner)
                                ])
                            @else
                                ?
                            @endif
                        </td>
                        <td data-field="abbreviation">
                            {{ $adminGroup->abbreviation }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminGroup->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminGroup->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($adminGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-group.show', ownerParams($adminGroup, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($adminGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-group.edit', ownerParams($adminGroup, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($adminGroup, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.admin-group.destroy', $adminGroup) !!}" method="POST">
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
                        @if ($isRootAdmin)
                            <td colspan="8">No admin groups found.</td>
                        @else
                            <td colspan="6">No groups found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $adminGroups->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
