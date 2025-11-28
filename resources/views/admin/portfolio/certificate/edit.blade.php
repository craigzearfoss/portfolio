@extends('admin.layouts.default', [
    'title' => 'Certificate: ' . $certificate->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',             'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',        'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certificates',     'href' => route('admin.portfolio.certificate.index') ],
        [ 'name' => $certificate->name, 'href' => route('admin.portfolio.certificate.show', $certificate->id) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.certificate.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.certificate.update', $certificate) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.certificate.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $certificate->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $certificate->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $certificate->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $certificate->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $certificate->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $certificate->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'organization',
                'value'     => old('organization') ?? $certificate->organization,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'academy',
                'value'     => old('academy_id') ?? $certificate->academy_id,
                'list'      => \App\Models\Portfolio\Academy::listOptions([], 'id', 'name', true),
                'required'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'year',
                'value'     => old('year') ?? $certificate->year,
                'min'       => 1980,
                'max'       => 2050,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'received',
                'value'     => old('received') ?? $certificate->received,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'expiration',
                'value'     => old('expiration') ?? $certificate->expiration,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'certificate_url',
                'label'     => 'certificate url',
                'value'     => old('certificate_url') ?? $certificate->certificate_url,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $certificate->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $certificate->link,
                'name' => old('link_name') ?? $certificate->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $certificate->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $certificate->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $certificate->image,
                'credit'  => old('image_credit') ?? $certificate->image_credit,
                'source'  => old('image_source') ?? $certificate->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $certificate->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $certificate->public,
                'readonly' => old('readonly') ?? $certificate->readonly,
                'root'     => old('root') ?? $certificate->root,
                'disabled' => old('disabled') ?? $certificate->disabled,
                'demo'     => old('demo') ?? $certificate->demo,
                'sequence' => old('sequence') ?? $certificate->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.certificate.index')
            ])

        </form>

    </div>

@endsection
