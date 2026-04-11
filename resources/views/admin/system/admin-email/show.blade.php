@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminEmail    = $adminEmail ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Email: ' . $adminEmail->email : 'Email: ' . $adminEmail->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                     'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                          'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                   'href' => route('admin.system.index',
                                                                                                !empty($owner)
                                                                                                    ? ['owner_id'=>$owner->id]
                                                                                                    : []
                                                                                                )],
        [ 'name' => $isRootAdmin ? 'Admin Email Addresses' : 'Email Addresses', 'href' => route('admin.system.admin-email.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Email' : 'Email' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($adminEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-email.edit', $adminEmail)])->render();
    }
    if (canCreate($adminEmail, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                                  'href' => route('admin.system.admin-email.create',
                                                                                      $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                                 )
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-email.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $adminEmail->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $adminEmail->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $adminEmail->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'label',
                'value' => $adminEmail->label
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $adminEmail->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $adminEmail->notes
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $adminEmail,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($adminEmail->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($adminEmail->updated_at)
            ])

        </div>
    </div>

@endsection
