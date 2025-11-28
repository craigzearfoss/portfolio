@extends('admin.layouts.default', [
    'title' => 'Certification: ' . $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',               'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',          'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',     'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => $certification->name, 'href' => route('admin.portfolio.certification.show', $certification->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.certification.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.certification.update', $certification) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.certification.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $certification->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $certification->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'label'     => 'abbreviation',
                'value'     => old('abbreviation') ?? $certification->abbreviation,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'certification_type_id',
                'label'    => 'certification type',
                'value'    => old('certification_type_id') ?? $certification->certification_type_id,
                'required' => true,
                'list'     => \App\Models\Portfolio\CertificationType::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'organization',
                'label'     => 'organization',
                'value'     => old('organization') ?? $certification->organization,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $certification->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $certification->link,
                'name' => old('link_name') ?? $certification->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $certification->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $certification->image,
                'credit'  => old('image_credit') ?? $certification->image_credit,
                'source'  => old('image_source') ?? $certification->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $certification->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo',
                'value'     => old('logo') ?? $certification->logo,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo_small',
                'value'     => old('logo_small') ?? $certification->logo_small,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $certification->public,
                'readonly' => old('readonly') ?? $certification->readonly,
                'root'     => old('root') ?? $certification->root,
                'disabled' => old('disabled') ?? $certification->disabled,
                'demo'     => old('demo') ?? $certification->demo,
                'sequence' => old('sequence') ?? $certification->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.certification.index')
            ])

        </form>

    </div>

@endsection
