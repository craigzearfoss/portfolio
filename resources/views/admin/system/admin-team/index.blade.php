@php
    $buttons = [];
    if (canCreate('admin-team', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Add New Admin Team', 'href' => route('admin.admin-team.create') ];
    }
    if (canRead('admin-group', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Groups', 'href' => route('admin.admin-group.index') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Teams',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Admin Teams' ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($adminTeams as $adminTeam)

                <tr data-id="{{ $adminTeam->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $adminTeam->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $adminTeam->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $adminTeam->abbreviation !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminTeam->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.admin-team.destroy', $adminTeam->id) !!}" method="POST">

                            @if(canRead($adminTeam))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.admin-team.show', $adminTeam->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($adminTeam))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.admin-team.edit', $adminTeam->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete($adminTeam))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '5' : '4' }}">There are no admin teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $adminTeams->links('vendor.pagination.bulma') !!}

    </div>

@endsection
