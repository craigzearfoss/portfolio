@extends('admin.layouts.default', [
    'title' => $academy->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'url' => route('admin.portfolio.academy.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => Request::header('referer') ?? route('admin.portfolio.academy.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.portfolio.academy.update', $academy) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $academy->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $academy->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? $academy->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $academy->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? $academy->image,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? $academy->image_credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? $academy->image_source,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? $academy->thumbnail,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $academy->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $academy->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $academy->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $academy->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $academy->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => Request::header('referer') ?? route('admin.portfolio.academy.index')
            ])

        </form>

    </div>

@endsection
