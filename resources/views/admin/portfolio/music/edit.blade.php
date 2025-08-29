@extends('admin.layouts.default', [
    'title' => $music->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Music',           'url' => route('admin.portfolio.music.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.portfolio.music.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.portfolio.music.update', $music) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
            'value' => '0',
        ])

        @include('admin.components.form-input-horizontal', [
            'name'      => 'name',
            'value'     => old('name') ?? $music->name,
            'required'  => true,
            'maxlength' => 255,
            'message'   => $message ?? '',
        ])

        @include('admin.components.form-input-horizontal', [
            'name'      => 'slug',
            'value'     => old('slug') ?? $music->slug,
            'required'  => true,
            'maxlength' => 255,
            'message'   => $message ?? '',
        ])

        @include('admin.components.form-checkbox-horizontal', [
            'name'            => 'professional',
            'value'           => 1,
            'unchecked_value' => 0,
            'checked'         => old('professional') ?? $music->professional,
            'message'         => $message ?? '',
        ])

        @include('admin.components.form-checkbox-horizontal', [
            'name'            => 'personal',
            'value'           => 1,
            'unchecked_value' => 0,
            'checked'         => old('personal') ?? $music->personal,
            'message'         => $message ?? '',
        ])

        @include('admin.components.form-input-horizontal', [
            'name'      => 'link',
            'value'     => old('link') ?? $music->link,
            'required'  => true,
            'maxlength' => 255,
            'message'   => $message ?? '',
        ])

        @include('admin.components.form-textarea-horizontal', [
            'name'    => 'description',
            'id'      => 'inputEditor',
            'value'   => old('description') ?? $music->description,
            'message' => $message ?? '',
        ])

        @include('admin.components.form-file-upload-horizontal', [
            'name'    => 'image',
            'value'   => old('image') ?? $music->image,
            'message' => $message ?? '',
        ])

        @include('admin.components.form-file-upload-horizontal', [
            'name'    => 'thumbnail',
            'value'   => old('thumbnail') ?? $music->thumbnail,
            'message' => $message ?? '',
        ])

        @include('admin.components.form-input-horizontal', [
            'type'        => 'number',
            'name'        => 'sequence',
            'value'       => old('sequence') ?? $music->sequence,
            'min'         => 0,
            'message'     => $message ?? '',
        ])

        @include('admin.components.form-checkbox-horizontal', [
            'name'            => 'public',
            'value'           => 1,
            'unchecked_value' => 0,
            'checked'         => old('public') ?? $music->public,
            'message'         => $message ?? '',
        ])

        @include('admin.components.form-checkbox-horizontal', [
            'name'            => 'disabled',
            'value'           => 1,
            'unchecked_value' => 0,
            'checked'         => old('disabled') ?? $music->disabled,
            'message'         => $message ?? '',
        ])

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => route('admin.portfolio.music.index')
        ])

    </div>

@endsection
