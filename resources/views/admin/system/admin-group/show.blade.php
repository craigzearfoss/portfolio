@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Admin Group: ' . $adminGroup->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admin Groups',    'href' => route('admin.system.admin-group.index') ],
        [ 'name' => $adminGroup->name ]
    ];

    // set navigation buttons
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

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

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

            @include('admin.components.show-row-visibility', [
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

                <table class="table admin-table {{ $adminTableClasses ?? '' }}">
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
    </div>

@endsection
