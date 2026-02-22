@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'User Team: ' . $userTeam->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'User Teams',      'href' => route('admin.system.user-team.index') ],
        [ 'name' => $userTeam->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $userTeam, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user-team.edit', $userTeam)
                                                              ])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'user-team', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New User Team',
                                                               'href' => route('admin.system.user-team.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-team.index') ])->render();
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
                'value' => $userTeam->id
            ])

            @if(!empty($userTeam->owner))
                @include('admin.components.show-row-link', [
                    'name' => 'owner',
                    'label' => $userTeam->owner->username,
                    'href' => route('admin.system.user.show', $userTeam->owner)
                ])
            @else
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => '?'
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

            @include('admin.components.show-row-visibility', [
                'resource' => $userTeam,
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

                <h2 class="subtitle mb-0">
                    Team Members
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

                    @if(!empty($userTeam->members))

                        @foreach($userTeam->members as $member)

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
                                       href="{!! route('admin.system.user.show', $member->id) !!}">
                                        <i class="fa-solid fa-list"></i>
                                    </a>

                                    <a title="edit" class="button is-small px-1 py-0"
                                       href="{!! route('admin.system.user.edit', $member->id) !!}">
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
