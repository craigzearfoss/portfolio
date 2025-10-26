@extends('admin.layouts.default', [
    'title' => 'Resume: ' . $resume->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
        [ 'name' => $resume->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.resume.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="form">

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.resume.update', $resume) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.resume.index')
                ])

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $resume->id
                ])

                @if(isRootAdmin())
                    @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $resume->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $resume->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $resume->name,
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

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'primary',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('primary') ?? $resume->primary,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'content',
                    'value'   => old('content') ?? $resume->content,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'doc_url',
                    'label'     => 'doc url',
                    'value'     => old('doc_url') ?? $resume->doc_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'pdf_url',
                    'label'     => 'pdf url',
                    'value'     => old('pdf_url') ?? $resume->pdf_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'    => 'link',
                    'value'   => old('link') ?? $resume->link,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'    => 'link_name',
                    'label'   => 'link name',
                    'value'   => old('link_name') ?? $resume->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $resume->description,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'    => 'image',
                    'value'   => old('image') ?? $resume->image,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'image_credit',
                    'label'     => 'image credit',
                    'value'     => old('image_credit') ?? $resume->image_credit,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'image_source',
                    'label'     => 'image source',
                    'value'     => old('image_source') ?? $resume->image_source,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'    => 'thumbnail',
                    'value'   => old('thumbnail') ?? $resume->thumbnail,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'sequence',
                    'value'       => old('sequence') ?? $resume->sequence,
                    'min'         => 0,
                    'message'     => $message ?? '',
                ])

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'public',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('public') ?? $resume->public,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'readonly',
                                    'label'           => 'read-only',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('readonly') ?? $resume->readonly,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'root',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('root') ?? $resume->root,
                                    'disabled'        => !isRootAdmin(),
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'disabled',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('disabled') ?? $resume->disabled,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => Request::header('referer') ?? route('admin.career.reference.index')
                ])

            </form>

        </div>

@endsection
