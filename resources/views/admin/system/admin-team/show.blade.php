@php
    $buttons = [];
    if (canDelete($adminTeam, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.admin-team.edit', $adminTeam) ];
    }
    if (canCreate($adminTeam, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Team', 'href' => route('admin.admin-team.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.admin-team.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Admin Team: ' . $adminTeam->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Admin Teams',     'href' => route('admin.admin-team.index') ],
        [ 'name' => $adminTeam->name ]
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
            'value' => $adminTeam->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $adminTeam->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($adminTeam->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $adminTeam->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($adminTeam->abbreviation ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $adminTeam->description ?? ''
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

            <h2 class="subtitle">
                Team Members
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
                $members = $adminTeam->members();
                @endphp
                @if($members->count() > 0)

                    @foreach($members as $member)

                        <tr>
                            <td>
                                {{ $member->username }}
                            </td>
                            <td>
                                {{ htmlspecialchars($member->name ?? '') }}
                            </td>
                            <td>
                                {{ htmlspecialchars($member->email ?? '') }}
                            </td>
                            <td>
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.admin.show', $member->id) }}">
                                    <i class="fa-solid fa-list"></i>{{-- show --}}
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.admin.edit', $member->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
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
