@extends('admin.layouts.default', [
    'title' => $adminTeam->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'url' => route('admin.admin.index') ],
        [ 'name' => 'Admin Teams',     'url' => route('admin.admin-team.index') ],
        [ 'name' => 'Show' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',      'url' => route('admin.admin-team.edit', $adminTeam) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Team', 'url' => route('admin.admin-team.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',         'url' => referer('admin.admin-team.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $adminTeam->owner['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $adminTeam->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $adminTeam->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $adminTeam->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($adminTeam->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($adminTeam->updated_at)
        ])

    </div>

@endsection
