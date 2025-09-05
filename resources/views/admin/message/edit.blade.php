@extends('admin.layouts.default', [
    'title' => 'Edit Message',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Message',         'url' => route('admin.message.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-list"></i> Show',       'url' => route('admin.message.show', $message) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.message.index') ],
    ],
    'errors' => $errors ?? [],
    'success' => session('success') ?? null,
    'error' => session('error') ?? null,
])

@section('content')

    <div class="card form-container">

        <form action="{{ route('admin.message.update', $message) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input', [
                'name'      => 'name',
                'value'     => old('name') ?? $message->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ??  $message->email,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'name'      => 'subject',
                'value'     => old('subject') ??  $message->subject,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea', [
                'name'    => 'body',
                'value'   => old('body') ??  $message->body,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save',
                'cancel_url' => route('admin.message.index')
            ])

        </form>

    </div>

@endsection
