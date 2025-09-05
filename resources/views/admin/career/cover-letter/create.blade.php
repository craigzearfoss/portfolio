@extends('admin.layouts.default', [
    'title' =>'Add New Cover Letter',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',   'url' => route('admin.career.cover-letter.index') ],
        [ 'name' => 'Create' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.career.cover-letter.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.career.cover-letter.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => Auth::guard('admin')->user()->id,
                'value' => '0',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'slug',
                'value'     => old('slug') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'date',
                'value'     => old('date') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'content',
                'id'      => 'inputEditor',
                'value'   => old('content') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link',
                'value'    => old('link') ?? '',
                'required' => true,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link_name',
                'label'    => 'link name',
                'value'    => old('link_name') ?? '',
                'required' => true,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_link',
                'label'     => 'alt link',
                'value'     => old('alt_link') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'alt_link_name',
                'label'    => 'alt link name',
                'value'    => old('alt_link_name') ?? '',
                'required' => true,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'primary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('primary') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? 0,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? 0,
                'message'         => $message ?? '',
            ])

            @if (Auth::guard('admin')->user()->root)
                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'root',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('root') ?? 0,
                    'message'         => $message ?? '',
                ])
            @endif

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $coverLetter->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Cover Letter',
                'cancel_url' => route('admin.career.cover-letter.index')
            ])

        </form>

    </div>

@endsection
