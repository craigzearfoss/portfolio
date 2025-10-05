@extends('admin.layouts.default', [
    'title' =>'Add New Cover Letter',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',   'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => 'Attach' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.cover-letter.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card form-container p-4">

        <form action="{{ route('admin.career.cover-letter.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.cover-letter.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\Owner::listOptions([], true),
                    'message'  => $message ?? '',
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'        => 'application_id',
                'label'       => 'application',
                'value'       => old('application_id') ?? '',
                'list'        => \App\Models\Career\Application::listOptions(['owner_id' => $note->owner_id]),
                'message'     => $message ?? '',
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
                'name'     => 'cover_letter_url',
                'name'     => 'cover letter url',
                'value'    => old('cover_letter_url') ?? '',
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link',
                'value'    => old('link') ?? '',
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'     => 'link_name',
                'label'    => 'link name',
                'value'    => old('link_name') ?? '',
                'maxlength' => 255,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
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
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Attach Cover Letter',
                'cancel_url' => referer('admin.career.cover-letter.index')
            ])

        </form>

    </div>

@endsection
