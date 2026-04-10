@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\UserEmail;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Email: ' . $userEmail->email : 'Email: ' . $userEmail->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                         'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                  'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Email Addresses' : 'Email Addresses', 'href' => route('admin.system.user-email.index') ],
        [ 'name' => $isRootAdmin ? 'User Email' : 'Email' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($userEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user-email.edit', $userEmail)])->render();
    }
    if (canCreate($userEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                                  'href' => route('admin.system.user-email.create',
                                                                                  [ 'user_id' => $userEmail->user_id ])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-email.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $userEmail->id,
                'hide'  => !$isRootAdmin,
            ])

            @if(!empty($userEmail->user))
                @include('admin.components.show-row-link', [
                    'name' => 'user',
                    'label' => $userEmail->user->username,
                    'href' => route('admin.system.user.show', $userEmail->user)
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
                'value' => $userEmail->notes
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
