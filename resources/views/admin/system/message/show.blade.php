@php
    $buttons = [];
    if (canUpdate($message, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.system.message.edit', $message)])->render();
    }
    if (canCreate('message', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Message', 'href' => route('admin.system.message.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.system.message.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Message',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Messages',        'href' => route('admin.system.message.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $message->id
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

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $message->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $message->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $message->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $message->disabled
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'demo',
            'checked' => $message->demo
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

@endsection
