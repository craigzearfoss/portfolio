@extends('admin.layouts.default', [
    'title' =>'Add New Course',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Courses',         'url' => route('admin.portfolio.course.index') ],
        [ 'name' => 'Create' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.portfolio.course.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.portfolio.course.store') }}" method="POST">
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

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'professional',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('professional') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'personal',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('personal') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'year',
                'value'     => old('year') ?? date('Y'),
                'min'       => 2000,
                'max'       => date('Y'),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'completed',
                'value'     => old('completed') ?? null,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'academy',
                'value'     => old('academy_id') ?? 0,
                'list'      => \App\Models\Portfolio\Academy::listOptions(),
                'required'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'academy',
                'value'     => old('academy') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'instructor',
                'value'     => old('instructor') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'sponsor',
                'value'     => old('sponsor') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image',
                'value'   => old('image') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
              'name'    => 'image_credit',
              'label'   => 'image credit',
              'value'   => old('image_credit') ?? '',
              'message' => $message ?? '',
``          ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'image_source',
                'label'   => 'image source',
                'value'   => old('image_source') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('seq') ?? 0,
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
                    'disabled'        => !Auth('admin')->user()->root,
                    'message'         => $message ?? '',
                ])
            @endif

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Course',
                'cancel_url' => route('admin.portfolio.course.index')
            ])

        </form>

    </div>

@endsection
