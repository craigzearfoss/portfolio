@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $message     = $message ?? null;

    $title    = $pageTitle ?? 'Message';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages',        'href' => route('admin.system.message.index') ],
        [ 'name' => 'Show' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($message, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.message.edit', $message) ])->render();
    }
    if (canCreate($message, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Message',
                                                               'href' => route('admin.system.message.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
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
                'value' => $message->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'from admin',
                'checked' => $message->from_admin
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $message->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $message->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'subject',
                'value' => $message->subject
            ])

            @include('admin.components.show-row', [
                'name'  => 'body',
                'value' => $message->body
            ])

            <?php /*
            @include('admin.components.show-row', [
                'name'  => 'sequence',
                'value' => $message->sequence
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'public',
                'checked' => $message->is_public
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'read-only',
                'checked' => $message->is_readonly
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'root',
                'checked' => $message->is_root
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'disabled',
                'checked' => $message->is_disabled
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'demo',
                'checked' => $message->is_demo
            ])
            */ ?>

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($message->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($message->updated_at)
            ])

        </div>
    </div>

@endsection
