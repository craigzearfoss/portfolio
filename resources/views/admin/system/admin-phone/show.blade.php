@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminPhone    = $adminPhone ?? null;

    $title    = !$isRootAdmin
        ? str_replace('AdminPhone', 'Phone', getResourcePageTitle($adminPhone))
        : getResourcePageTitle($adminPhone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                        'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                 'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Phones' : 'Phones', 'href' => route('admin.system.admin-phone.index') ],
        [ 'name' => $adminPhone->phone ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($adminPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-phone.edit', $adminPhone) ])->render();
    }
    if (canCreate($adminPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Phone',
                                                                  'href' => route('admin.system.admin-phone.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-phone.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if ($isRootAdmin)
                @include('admin.components.favorites-box', [ 'label' => 'favorites', 'count' => $adminPhone->favorite_count ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $adminPhone->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $adminPhone->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $adminPhone->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'label',
                'value' => $adminPhone->label
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $adminPhone->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($adminPhone->notes))
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $adminPhone,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($adminPhone->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($adminPhone->updated_at)
            ])

        </div>
    </div>

@endsection
