@php
    use App\Enums\PermissionEntityTypes;

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $adminGroup, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-group.edit', $adminGroup)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'admin-group', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Group',
                                                               'href' => route('admin.system.admin-group.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-group.index') ])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Group: ' . $adminGroup->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admin Groups',    'href' => route('admin.system.admin-group.index') ],
        [ 'name' => $adminGroup->name ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $adminGroup->id
        ])

        @if($admin->root)
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

            <h2 class="subtitle mb-0">
                Group Members
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

                @if(!empty($adminGroup->members))

                    @foreach($adminGroup->members as $member)

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
