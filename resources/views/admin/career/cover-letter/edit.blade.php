@extends('admin.layouts.default', [
    'title' => $coverLetter->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',   'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => referer('admin.career.cover-letter.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.career.cover-letter.update', $coverLetter) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.cover-letter.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'    => 'owner_id',
                    'label'   => 'owner',
                    'value'   => old('owner_id') ?? $coverLetter->owner_id,
                    'list'    => \App\Models\Owner::listOptions(),
                    'message' => $message ?? '',
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'        => 'application_id',
                'label'       => 'application',
                'value'       => old('application_id') ?? $coverLetter->application_id,
                'list'        => \App\Models\Career\Application::listOptions(['owner_id' => $note->owner_id]),
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'date',
                'value'     => old('date') ?? $coverLetter->date,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'content',
                'id'      => 'inputEditor',
                'value'   => old('content') ?? $coverLetter->content,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'cover_letter_url',
                'name'     => 'cover letter url',
                'value'    => old('cover_letter_url') ?? $coverLetter->cover_letter_url,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link',
                'value'    => old('link') ?? $coverLetter->link,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link_name',
                'label'    => 'link name',
                'value'    => old('link_name') ?? $coverLetter->link_name,
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $coverLetter->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $coverLetter->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $coverLetter->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'readonly',
                'label'           => 'read-only',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('readonly') ?? $coverLetter->readonly,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'root',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('root') ?? $coverLetter->root,
                'disabled'        => !Auth::guard('admin')->user()->root,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $coverLetter->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.cover-letter.index')
            ])

        </form>

    </div>

@endsection
