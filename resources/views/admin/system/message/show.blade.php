@php
    $buttons = [];
    if (canDelete($message, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.system.message.edit', $message) ];
    }
    if (canCreate($message, currentAdminId())) {
        $button[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.message.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.message.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Message',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages',        'href' => route('admin.system.message.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' =>  $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $message->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($message->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => htmlspecialchars($message->email ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => htmlspecialchars($message->subject ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $message->body ?? ''
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
