@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Groups';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Groups' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'admin-group', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Group',
                                                               'href' => route('admin.system.admin-group.create')
                                                             ])->render();
    }
    if (canRead(PermissionEntityTypes::RESOURCE, 'admin-team', $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Teams',
                                                                'href' => route('admin.system.admin-team.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.system.admin-group.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $adminGroups->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>team</th>
                    <th>abbreviation</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>team</th>
                        <th>abbreviation</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($adminGroups as $adminGroup)

                    <tr data-id="{{ $adminGroup->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($adminGroup->owner))
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
                        <td data-field="name">
                            {!! $adminGroup->name !!}
                        </td>
                        <td data-field="team.name">
                            @if(!empty($adminGroup->team))
                                @include('admin.components.link', [
                                    'name' => $adminGroup->team->name,
                                    'href' => route('admin.system.admin-team.show', $adminGroup->owner)
                                ])
                            @else
                                ?
                            @endif
                        </td>
                        <td data-field="abbreviation">
                            {!! $adminGroup->abbreviation !!}
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminGroup->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-group.show', $adminGroup),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-group.edit', $adminGroup),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $adminGroup, $admin))
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
                        <td colspan="{{ $admin->root ? '6' : '5' }}">There are no groups.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $adminGroups->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
