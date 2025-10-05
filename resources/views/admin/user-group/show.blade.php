@extends('admin.layouts.default', [
    'title' => 'User Group: ' . $userGroup->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'href' => route('admin.admin.index') ],
        [ 'name' => 'Admin Groups',    'href' => route('admin.admin-group.index') ],
        [ 'name' => $userGroup->name ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',       'href' => route('admin.admin-group.edit', $userGroup) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Group', 'href' => route('admin.admin-group.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',          'href' => referer('admin.admin-group.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

            @if(isRootAdmin())
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $userGroup->owner['username'] ?? ''
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'team',
                'value' => $userGroup->team['name'] ?? ''
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

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $userGroup->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($userGroup->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($userGroup->updated_at)
        ])

    </div>

@endsection
