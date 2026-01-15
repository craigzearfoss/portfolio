@php
    $buttons = [];
    if (canDelete($adminGroup, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.admin-group.edit', $adminGroup) ];
    }
    if (canCreate($adminGroup, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Group', 'href' => route('admin.admin-group.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.admin-group.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Group: ' . $adminGroup->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Admin Groups',    'href' => route('admin.admin-group.index') ],
        [ 'name' => $adminGroup->name ]
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

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $adminGroup->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $adminGroup->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'team',
            'value' => $adminGroup->team->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $adminGroup->name
        ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $adminGroup->slug
            ])

            @include('admin.components.show-row', [
                'name'  => 'abbreviation',
                'value' => $adminGroup->abbreviation
            ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $adminGroup->description
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $adminGroup,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($adminGroup->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($adminGroup->updated_at)
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
                    $members = $adminGroup->members();
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
                                   href="{!! route('admin.admin.show', $member->id) !!}">
                                    <i class="fa-solid fa-list"></i>
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{!! route('admin.admin.edit', $member->id) !!}">
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
