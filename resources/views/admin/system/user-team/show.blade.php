@extends('admin.layouts.default', [
    'title' => 'User Team: ' . $userTeam->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Teams',      'href' => route('admin.system.user-team.index') ],
        [ 'name' => $userTeam->name ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'href' => route('admin.system.user-team.edit', $userTeam) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New User Team', 'href' => route('admin.system.user-team.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'href' => referer('admin.system.user-team.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $userTeam->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $userTeam->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $userTeam->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $userTeam->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $userTeam->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $userTeam->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $userTeam->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($userTeam->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($userTeam->updated_at)
        ])

        <div class="card p-4">

            <h2 class="subtitle">
                User Team Members
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
                    $members = $userTeam->members();
                @endphp
                @if($members->count() > 0)

                    @foreach($members as $member)

                        <tr>
                            <td>
                                {{ $member->username }}
                            </td>
                            <td>
                                {{ $member->name }}
                            </td>
                            <td>
                                {{ $member->email }}
                            </td>
                            <td>
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.user.show', $member->id) }}">
                                    <i class="fa-solid fa-list"></i>{{-- show --}}
                                </a>

                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.user.edit', $member->id) }}">
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
