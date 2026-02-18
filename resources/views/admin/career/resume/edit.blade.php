@php
    use App\Models\System\Owner;

    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Resumes',          'href' => route('admin.career.note.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Resume',           'href' => route('admin.career.resume.show', $resume, ['application_id' => $application->id]) ],
            [ 'name' => 'Edit' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
            [ 'name' => 'Resume',          'href' => route('admin.career.resume.show', $resume) ],
            [ 'name' => 'Edit' ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Edit Resume' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.resume.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.resume.update', array_merge([$resume], request()->all()) }}" method="POST">
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

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $resume->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
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

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'primary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('primary') ?? $resume->primary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'date',
                'label'     => 'date',
                'value'     => old('date') ?? $resume->date,
                'message'   => $message ?? '',
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

            @include('admin.components.form-select-horizontal', [
                'name'     => 'file_type',
                'label'    => 'file type',
                'value'    => old('file_type') ?? $resume->file_type,
                'required' => true,
                'list'     => \App\Models\System\Resume::fileTypes(true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $resume->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $resume->link,
                'name' => old('link_name') ?? $resume->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $resume->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $resume->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $resume->image,
                'credit'  => old('image_credit') ?? $resume->image_credit,
                'source'  => old('image_source') ?? $resume->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $resume->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $resume->public,
                'readonly'    => old('readonly') ?? $resume->readonly,
                'root'        => old('root')     ?? $resume->root,
                'disabled'    => old('disabled') ?? $resume->disabled,
                'demo'        => old('demo')     ?? $resume->demo,
                'sequence'    => old('sequence') ?? $resume->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.resume.index')
            ])

        </form>

    </div>

@endsection
