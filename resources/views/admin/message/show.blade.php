@extends('admin.layouts.default', [
    'title' => 'Message',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Message',         'url' => route('admin.message.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.message.edit', $message) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Library', 'url' => route('admin.message.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => referer('admin.dictionary.index') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $message->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $message->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $message->disabled
        ])

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
