@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $userEmail   = $userEmail ?? null;

    $title    = !$isRootAdmin
        ? str_replace('UserEmail', 'Email', getResourcePageTitle($userEmail))
        : getResourcePageTitle($userEmail);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Emails' : 'Emails', 'href' => route('admin.system.user-email.index') ],
        [ 'name' => $isRootAdmin ? 'User Email' : 'Email' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($userEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user-email.edit', $userEmail) ])->render();
    }
    if (canCreate($userEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                                  'href' => route('admin.system.user-email.create', !empty($user) ? [ 'user_id' => $user->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-email.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if ($isRootAdmin)
                @include('admin.components.favorites-box', [ 'label' => 'favorites', 'count' => $userEmail->favorite_count ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $userEmail->id,
                'hide'  => !$isRootAdmin,
            ])

            @if (!empty($userEmail->user))
                @include('admin.components.show-row-link', [
                    'link_name' => 'user',
                    'name'      => $userEmail->user->username,
                    'href'      => route('admin.system.user.show', $userEmail->user)
                ])
            @else
                @include('admin.components.show-row', [
                    'name'  => 'user',
                    'value' => '?'
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $userEmail->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'label',
                'value' => $userEmail->label
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $userEmail->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($userEmail->notes))
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $userEmail,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($userEmail->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($userEmail->updated_at)
            ])

        </div>
    </div>

@endsection
