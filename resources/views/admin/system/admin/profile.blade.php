@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $thisAdmin->name ]
    ];

    // set navigation buttons
    $buttons = [];
    $buttons[] = view('admin.components.nav-button-view', [ 'name' => 'View Profile',
                                                            'href' => route('admin.system.admin.show', $thisAdmin)
                                                          ])->render();
    if (canUpdate(PermissionEntityTypes::RESOURCE, $thisAdmin, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin.edit', $thisAdmin) ])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'admin', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Admin',
                                                               'href' => route('admin.system.admin.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    if (canUpdate(PermissionEntityTypes::RESOURCE, $thisAdmin, $admin)) {
        $buttons[] = view('admin.components.nav-button', [ 'name' => 'Change Password',
                                                           'icon'=>'fa-key',
                                                           'href' => route('admin.system.admin.change-password', $thisAdmin)
                                                         ])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin.index', $thisAdmin) ])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin: ' . $thisAdmin->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">

        <div class="show-container floating-div card p-4 mb-2 mr-2">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $thisAdmin->id
            ])

            @include('admin.components.show-row', [
                'name'  => 'user name',
                'value' => $thisAdmin->username
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $thisAdmin->name
            ])

            @php
                $adminTeamListItems = [];
                foreach ($thisAdmin->teams as $adminTeam) {
                    $adminTeamListItems[] = view('admin.components.link', [
                        'name' => $adminTeam->name,
                        'href' => route('admin.system.admin-team.show', $adminTeam)
                    ]) . ($adminTeam->id == $thisAdmin->team->id ? ' (current team)' : '');
                }
            @endphp
            @include('admin.components.show-row', [
                'name'  => 'teams',
                'value' => !empty($adminTeamListItems) ? implode('<br>', $adminTeamListItems) : '',
            ])

            @php
                $adminGroupListItems = [];
                foreach ($thisAdmin->groups as $adminGroup) {
                    $adminGroupListItems[] = view('admin.components.link', [
                        'name' => $adminGroup->name,
                        'href' => route('admin.system.admin-group.show', $adminGroup)
                    ]) . (!empty($adminGroup->team) ? ' (' . $adminGroup->team->name . ')' : '');
                }
            @endphp
            @include('admin.components.show-row', [
                'name'  => 'groups',
                'value' => !empty($adminGroupListItems) ? implode('<br>', $adminGroupListItems) : '',
            ])

            @include('admin.components.show-row', [
                'name'  => 'role',
                'value' => $thisAdmin->role
            ])

            @include('admin.components.show-row', [
                'name'  => 'employer',
                'value' => $thisAdmin->employer
            ])

            @include('admin.components.show-row', [
                'name'  => 'employment status',
                'value' => $thisAdmin->employmnentStatus->name ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $thisAdmin->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $thisAdmin->email
            ])

            @include('admin.components.show-row', [
                'name'  => '',
                'value' => view('admin.components.link', [
                               'name'   => '<i class="fa fa-file-text" aria-hidden="true"></i>Resume',
                               'href'   => route('admin.career.resume.preview', $thisAdmin),
                               'class'  => 'button is-primary is-small px-1 py-0',
                               'style'  => 'font-size: 1rem;',
                               'title'  => 'Resume',
                           ])
            ])

        </div>

        <div class="show-container floating-div card p-4 mb-2">

            @include('admin.components.image', [
                'src'      => $thisAdmin->image,
                'width'    => '300px',
                'download' => true,
                'external' => true,
            ])

        </div>

        @foreach($dbColumns as $title=>$resources)

            <div class="card floating-div m-2 p-4">

                <div class="card-head" style="border-bottom: #5c636a 2px outset;">
                    <strong>{{ $title }}</strong>
                </div>
                <div class="card-body">
                    <div class="list is-hoverable">
                        <ul class="menu-list" style="max-width: 20em;">

                            @foreach ($resources as $resource)

                                <li>
                                    @include('admin.components.link', [
                                        'name'  => $resource->plural,
                                        'href'  => route('admin.'.$resource->database_name.'.'.$resource->name.'.index',
                                                         $admin->root && !empty($owner) ? [ 'owner_id' => $owner ] : []
                                                   ),
                                        'class' => 'list-item',
                                        'style' => [
                                            'padding: 0.2rem',
                                            'white-space: nowrap',
                                            'margin-left: ' . (12 * ($resource->menu_level - 1)) . 'px',
                                        ],
                                    ])
                                </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@endsection
