@php
    $buttons = [];
    if (canDelete($userGroup, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.admin-group.edit', $userGroup) ];
    }
    if (canCreate($userGroup, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Add New User Group', 'href' => referer('admin.system.admin-group.index') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.admin.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'User Group: ' . $userGroup->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'User Groups',     'href' => route('root.user-group.index') ],
        [ 'name' => $userGroup->name ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $userGroup->id
        ])

        @if(isRootAdmin())
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
                                   href="{!! route('root.user.show', $member->id) !!}">
                                    <i class="fa-solid fa-list"></i>
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{!! route('root.user.edit', $member->id) !!}">
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
