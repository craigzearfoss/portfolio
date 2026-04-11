@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminGroup    = $adminGroup ?? null;

    $title    = $pageTitle ?? 'Admin Group: ' . $adminGroup->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index',
                                                       !empty($owner)
                                                           ? ['owner_id'=>$owner->id]
                                                           : []
                                                      )],
        [ 'name' => 'Admin Groups',    'href' => route('admin.system.admin-group.index') ],
        [ 'name' => $adminGroup->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($adminGroup, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-group.edit', $adminGroup)])->render();
    }
    if (canCreate($adminGroup, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Admin Group',
                                                               'href' => route('admin.system.admin-group.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-group.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $adminGroup->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $adminGroup->owner->username,
                'hide'  => !$isRootAdmin,
            ])

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
