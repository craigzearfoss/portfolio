@extends('admin.layouts.default', [
    'title' => $resume->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'url' => route('admin.career.resume.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.career.resume.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form">

        <div class="form-container">

            <form action="{{ route('admin.career.resume.update', $resume) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.components.form-hidden', [
                    'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
                    'value' => '0',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $resume->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'slug',
                    'value'     => old('slug') ?? $resume->slug,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'date',
                    'name'      => 'date',
                    'value'     => old('date') ?? $resume->date,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'link',
                    'value'     => old('link') ?? $resume->link,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_link',
                    'label'     => 'alt link',
                    'value'     => old('alt_link') ?? $resume->alt_link,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $resume->description,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'primary',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('primary') ?? $resume->primary,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'sequence',
                    'value'       => old('sequence') ?? $resume->sequence,
                    'min'         => 0,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'public',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('public') ?? $resume->public,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'disabled',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('disabled') ?? $resume->disabled,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => route('admin.career.resume.index')
                ])

            </form>

    </div>

@endsection
