@php
    $buttons = [];
    if (canDelete($message, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('root.message.edit', $message) ];
    }
    if (canCreate($message, loggedInAdminId())) {
        $button[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('root.message.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.message.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Message',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Messages',        'href' => route('root.message.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    =>  $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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
