@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'User Groups';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'user Groups' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'user-group', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New User Group',
                                                               'href' => route('admin.system.user-group.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(PermissionEntityTypes::RESOURCE, 'user-team', $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'User Teams',
                                                                'href' => route('admin.system.user-team.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $userGroups->links('vendor.pagination.bulma') !!}
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

                @forelse ($userGroups as $userGroup)

                    <tr data-id="{{ $userGroup->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $userGroup->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $userGroup->name !!}
                        </td>
                        <td data-field="team.name">
                            {!! $userGroup->team->name ?? '' !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $userGroup->abbreviation !!}
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userGroup->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $userGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-group.show', $userGroup),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $userGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-group.edit', $userGroup),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($userGroup->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($userGroup->link_name) ? $userGroup->link_name : 'link',
                                        'href'   => $userGroup->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $userGroup, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.user-group.destroy', $userGroup) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '6' : '5' }}">There are no user groups.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $userGroups->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
