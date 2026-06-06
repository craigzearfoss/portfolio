@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $userPhone   = $userPhone ?? null;

    $title    = !$isRootAdmin
        ? str_replace('UserPhone', 'Phone', getResourcePageTitle($userPhone))
        : getResourcePageTitle($userPhone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Phones' : 'Phones', 'href' => route('admin.system.user-phone.index') ],
        [ 'name' => $isRootAdmin ? 'User Phone' : 'Phone' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($userPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user-phone.edit', $userPhone) ])->render();
    }
    if (canCreate($userPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Phone',
                                                                  'href' => route('admin.system.user-phone.create', !empty($user) ? [ 'user_id' => $user->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-phone.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $userPhone->id,
                'hide'  => !$isRootAdmin,
            ])

            @if (!empty($userPhone->user))
                @include('admin.components.show-row-link', [
                    'link_name' => 'user',
                    'name'      => $userPhone->user->username,
                    'href'      => route('admin.system.user.show', $userPhone->user)
                ])
            @else
                @include('admin.components.show-row', [
                    'name'  => 'user',
                    'value' => '?'
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $userPhone->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'label',
                'value' => $userPhone->label
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $userPhone->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($userPhone->notes))
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $userPhone,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($userPhone->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($userPhone->updated_at)
            ])

        </div>
    </div>

@endsection
