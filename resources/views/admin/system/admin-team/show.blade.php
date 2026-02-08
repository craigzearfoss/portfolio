@php
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $adminTeam, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-team.edit', $adminTeam)])->render();
    }
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'admin-team', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Team',
                                                               'href' => route('admin.system.admin-team.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-team.index') ])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Team: ' . $adminTeam->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admin Teams',     'href' => route('admin.system.admin-team.index') ],
        [ 'name' => $adminTeam->name ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $adminTeam->id
        ])

        @if(!empty($adminTeam->owner))
            @include('admin.components.show-row-link', [
                'name' => 'owner',
                'label' => $adminTeam->owner->username,
                'href' => route('admin.system.admin.show', $adminTeam->owner)
            ])
        @else
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => '?'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $adminTeam->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $adminTeam->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $adminTeam->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $adminTeam->description
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $adminTeam,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($adminTeam->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($adminTeam->updated_at)
        ])

        <div class="card p-4">

            <h2 class="subtitle mb-0">
                Team Members
            </h2>
            <hr class="m-1">

            <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                <thead>
                <th>username</th>
                <th>name</th>
                <th>email</th>
                <th></th>
                </thead>
                <tbody>

                @if(!empty($adminTeam->members))

                    @foreach($adminTeam->members as $member)

                        <tr>
                            <td>
                                {!! $member->username !!}
                            </td>
                            <td>
                                {!! $member->name !!}
                            </td>
                            <td>
                                {!! $member->email !!}
                            </td>
                            <td>
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{!! route('admin.system.admin.show', $member->id) !!}">
                                    <i class="fa-solid fa-list"></i>
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{!! route('admin.system.admin.edit', $member->id) !!}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>

                    @endforeach

                @else

                    <tr>
                        <td colspan="3">
                            No members found.
                        </td>
                    </tr>

                @endif

                </tbody>
            </table>

        </div>

    </div>

@endsection
