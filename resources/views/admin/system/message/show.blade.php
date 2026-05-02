@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $thisMessage = $thisMessage ?? null;

    $title    = $pageTitle ?? 'Message: ' . $thisMessage->subject . ' (from ' . $thisMessage->name . ')' ;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages',        'href' => route('admin.system.message.index') ],
        [ 'name' => $thisMessage->subject . ' (from ' . $thisMessage->name . ')' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($thisMessage, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.message.edit', $thisMessage) ])->render();
    }
    if (canCreate($thisMessage, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Message',
                                                                  'href' => route('admin.system.message.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.message.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div" style="width: 40rem;">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $thisMessage->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'from admin',
                'checked' => $thisMessage->from_admin
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $thisMessage->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $thisMessage->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'subject',
                'value' => $thisMessage->subject
            ])

            @include('admin.components.show-row', [
                'name'  => 'body',
                'value' => $thisMessage->body
            ])

            <?php /*
            @include('admin.components.show-row', [
                'name'  => 'sequence',
                'value' => $thisMessage->sequence
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'public',
                'checked' => $thisMessage->is_public
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'read-only',
                'checked' => $thisMessage->is_readonly
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'root',
                'checked' => $thisMessage->is_root
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'disabled',
                'checked' => $thisMessage->is_disabled
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'demo',
                'checked' => $thisMessage->is_demo
            ])
            */ ?>

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($thisMessage->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($thisMessage->updated_at)
            ])

        </div>
    </div>

@endsection
