@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\UserGroup;

    $title    = $pageTitle ?? 'Admin Teams';
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
        [ 'name' => 'Teams' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Team',
                                                               'href' => route('admin.system.admin-team.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(UserGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Groups',
                                                                'href' => route('admin.system.admin-group.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.system-owner', [ 'action' => route('admin.system.admin-team.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $adminTeams->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
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
                        <th>abbreviation</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($adminTeams as $adminTeam)

                    <tr data-id="{{ $adminTeam->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($adminTeam->owner))
                                    @include('admin.components.link', [
                                        'name' => $adminTeam->owner->username,
                                        'href' => route('admin.system.admin.show', $adminTeam->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $adminTeam->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $adminTeam->abbreviation !!}
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminTeam->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($adminTeam, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-team.show', $adminTeam),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($adminTeam, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-team.edit', $adminTeam),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($adminTeam, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.admin-team.destroy', $adminTeam) !!}"
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
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No admin teams found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No teams found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $adminTeams->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
