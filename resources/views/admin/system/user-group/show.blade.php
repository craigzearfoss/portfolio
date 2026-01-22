@php
    $buttons = [];
    if (canUpdate($userGroup, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.system.user-group.edit', $userGroup)])->render();
    }
    if (canCreate('user-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New User Group', 'href' => route('admin.system.user-group.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.system.user-group.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'User Group: ' . $userGroup->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Groups',     'href' => route('admin.system.user-group.index') ],
        [ 'name' => $userGroup->name ]
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

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $userGroup->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $userGroup->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'team',
            'value' => $userGroup->team->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $userGroup->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $userGroup->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $userGroup->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $userGroup->description
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $userGroup,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($userGroup->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($userGroup->updated_at)
        ])

        <div class="card p-4">

            <h2 class="subtitle">
                Group Members
            </h2>

            <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                <thead>
                <th>username</th>
                <th>name</th>
                <th>email</th>
                <th></th>
                </thead>
                <tbody>

                @php
                    $members = $userGroup->members();
                @endphp
                @if($members->count() > 0)

                    @foreach($members as $member)

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
                                   href="{!! route('admin.user.show', $member->id) !!}">
                                    <i class="fa-solid fa-list"></i>
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{!! route('admin.user.edit', $member->id) !!}">
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
