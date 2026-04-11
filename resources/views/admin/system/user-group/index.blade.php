@php
    use App\Models\System\UserGroup;
    use App\Models\System\UserTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

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
    if (canCreate(UserGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New User Group',
                                                               'href' => route('admin.system.user-group.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(UserTeam::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'User Teams',
                                                                'href' => route('admin.system.user-team.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $userGroups->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>team</th>
                        <th>abbreviation</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                    @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
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
                        @if($isRootAdmin)
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
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userGroup->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($userGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-group.show', $userGroup),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($userGroup, $admin))
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

                                @if(canDelete($userGroup, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.user-group.destroy', $userGroup) !!}"
                                          method="POST">
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
                        @if($isRootAdmin)
                            <td colspan="{{ $isRootAdmin ? '6' : '5' }}">No user groups found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '6' : '5' }}">No groups found.</td>
                        @endif
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
