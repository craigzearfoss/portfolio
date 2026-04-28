@php
    use App\Models\System\UserGroup;
    use App\Models\System\UserTeam;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\UserTeam';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $userTeam    = $userTeam ?? null;

    $title    = $pageTitle ?? 'User Teams';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Teams' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserTeam::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New User Team',
                                                               'href' => route('admin.system.user-team.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canRead(UserGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'User Groups',
                                                                'href' => route('admin.system.user-group.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-user-team')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.user-team.export', request()->except([ 'page' ])),
                'filename' => 'user_teams_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ Number::format($userTeams->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $userTeams->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owning user</th>
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
                            <th>owning user</th>
                        @endif
                        <th>name</th>
                        <th>abbreviation</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($userTeams as $userTeam)

                    <tr data-id="{{ $userTeam->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $userTeam->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $userTeam->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $userTeam->abbreviation ?? '' !!}
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userTeam->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($userTeam, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-team.show', $userTeam),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($userTeam, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-team.edit', $userTeam),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($userTeam->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($userTeam->link_name) ? $userTeam->link_name : 'link',
                                        'href'   => $userTeam->link,
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

                                @if(canDelete($userTeam, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.user-team.destroy', $userTeam) !!}" method="POST">
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
                            <td colspan="{{$isRootAdmin ? '5' : '4' }}">No user teams found.</td>
                        @else
                            <td colspan="{{$isRootAdmin ? '5' : '4' }}">No teams found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $userTeams->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
