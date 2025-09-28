@extends('admin.layouts.default', [
    'title' => $userTeam->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.user.index') ],
        [ 'name' => 'User Teams',      'href' => route('admin.user-team.index') ],
        [ 'name' => 'Show' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',      'url' => route('admin.user-team.edit', $userTeam) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New User Team', 'url' => route('admin.user-team.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',         'url' => referer('admin.user-team.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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

    </div>

@endsection
