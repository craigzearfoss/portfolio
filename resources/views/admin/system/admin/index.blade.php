@php
    use App\Models\System\Admin;
    use App\Models\System\AdminGroup;
    use App\Models\System\AdminTeam;
    use App\Models\System\User;
    use App\Models\System\UserTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\Admin';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Admins';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Admin::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin',
                                                                  'href' => route('admin.system.admin.create')
                                                                ])->render();
    }
    if (canRead(UserTeam::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Teams',
                                                                   'href' => route('admin.system.admin-team.index')
                                                                 ])->render();
    }
    if (canRead(AdminGroup::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-view', [ 'name' => 'Admin Groups',
                                                                   'href' => route('admin.system.admin-group.index')
                                                                 ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 90em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.admin.export', request()->except([ 'page' ])),
                'filename' => 'admins_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($allAdmins->total()) }} {{ ($allAdmins->total() === 1) ? 'admin' : 'admins' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $allAdmins->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the admin is disabled.</p>

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
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th style="white-space: nowrap;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'username',
                                'sort'  => 'username|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'label',
                                'sort'  => 'label|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'team',
                                'sort'  => 'team_name|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'email',
                                'sort'  => 'email|asc',
                            ])
                        </th>
                        <th class="has-text-centered">verified</th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'status',
                                'sort'  => 'status|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($allAdmins as $thisAdmin)

                    <tr data-id="{{ $thisAdmin->id }}" {!! $thisAdmin->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td data-field="id">
                            {{ $thisAdmin->id }}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $thisAdmin->name }}
                        </td>
                        <td data-field="username" style="white-space: nowrap;">
                            {{ $thisAdmin->username }}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'system.admin', 'data-id' => $thisAdmin->id ]
                           ])
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {{ $thisAdmin->label }}
                        </td>
                        <td data-field="admin_team_id" style="white-space: nowrap;">
                            @if (!empty($admin->admin_team_id))
                                @include('admin.components.link', [
                                    'name' => $thisAdmin->team->name ?? '',
                                    'href' => route('admin.system.admin-team.show',
                                                    [ $thisAdmin, AdminTeam::where('id', $thisAdmin->team->id)->first() ]
                                              )
                                ])
                            @endif
                        </td>
                        <td data-field="email" style="white-space: nowrap;">
                            {{ $thisAdmin->email }}
                        </td>
                        <td data-field="email_verified_at" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $thisAdmin->email_verified_at ])
                        </td>
                        <td data-field="status">
                            {{ User::statusName($thisAdmin->status) ?? '' }}
                        </td>
                        <td data-field="is_root" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $thisAdmin->is_root ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $thisAdmin->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($thisAdmin, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => $isRootAdmin
                                            ? route('admin.system.admin.profile', $thisAdmin)
                                            : route('admin.system.admin.show', $thisAdmin),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($thisAdmin, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin.edit', $thisAdmin),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($thisAdmin->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($thisAdmin->link_name) ? $thisAdmin->link_name : 'link',
                                        'href'   => $thisAdmin->link,
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

                                @if (canUpdate($thisAdmin, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'change password',
                                        'href'  => route('admin.system.admin.change-password', $thisAdmin),
                                        'icon'  => 'fa-key'
                                    ])
                                @endif

                                @if (canDelete($thisAdmin, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.admin.destroy', $thisAdmin) !!}"
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
                        <td colspan="11">No admins found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $allAdmins->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
