@php
    use App\Models\System\UserGroup;
    use App\Models\System\UserTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\UserGroup';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? $isRootAdmin ? 'User Groups' : 'Groups';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Groups' : 'Groups' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => $isRootAdmin ? 'Create New User Group' : 'Create New Group',
                                                                  'href' => route('admin.system.user-group.create', !empty($user) ? [ 'user_id' => $user->id ] : [])
                                                                ])->render();
    }
    if (canRead(UserTeam::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => $isRootAdmin ? 'User Teams' : 'Teams',
                                                                'href' => route('admin.system.user-team.index')
                                                              ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-user-group')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.user-group.export', request()->except([ 'page' ])),
                'filename' => 'user_groups_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($userGroups->total()) }} {{ $isRootAdmin ? 'user ' : '' }}{{ ($userGroups->total() === 1) ? 'group' : 'groups' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $userGroups->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the user group is disabled.</p>

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
                                    'name'  => 'user',
                                    'sort'  => 'user_username|asc',
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

                @forelse ($userGroups as $userGroup)

                    <tr data-id="{{ $userGroup->id }}" {!! $userGroup->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $userGroup->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $userGroup->$userTeam->username,
                                    'href' => route('admin.system.admin.show', $userGroup->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $userGroup->name }}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'system.user_group', 'data-id' => $userGroup->id ]
                           ])
                        </td>
                        <td data-field="team.name" style="white-space: nowrap;">
                            {{ $userGroup->team->name ?? '' }}
                        </td>
                        <td data-field="abbreviation" style="white-space: nowrap;">
                            {{ $userGroup->abbreviation }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userGroup->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userGroup->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($userGroup, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-group.show', $userGroup),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($userGroup, $admin))
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

                                @if (canDelete($userGroup, $admin))
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
                        @if ($isRootAdmin)
                            <td colspan="8">No user groups found.</td>
                        @else
                            <td colspan="6">No groups found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $userGroups->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
