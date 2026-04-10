@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\UserPhone;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Phone: ' . $adminPhone->phone : 'Phone: ' . $adminPhone->phone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                         'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                  'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.user-phone.index') ],
        [ 'name' => $isRootAdmin ? 'User Phone Number' : 'Phone' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($userPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user-phone.edit', $userPhone)])->render();
    }
    if (canCreate($userPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Phone',
                                                                  'href' => route('admin.system.user-phone.create',
                                                                                  [ 'user_id' => $userPhone->user->id ])
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

            @if(!empty($userPhone->user))
                @include('admin.components.show-row-link', [
                    'name' => 'user',
                    'label' => $userPhone->user->username,
                    'href' => route('admin.system.user.show', $userPhone->user)
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
                'value' => $userPhone->notes
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
