@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($title) ? $title : 'Cover Letter: ' . $coverLetter->name),
    'breadcrumbs'      => [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',    'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => $coverLetter->name, 'href' => route('admin.career.cover-letter.show', $coverLetter) ],
        [ 'name' => 'Edit' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.cover-letter.index')])->render(),
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

        <form action="{{ route('admin.career.cover-letter.update', array_merge([$coverLetter], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.cover-letter.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $coverLetter->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $coverLetter->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $coverLetter->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'    => 'application_id',
                'label'   => 'application',
                'value'   => old('application_id') ?? $coverLetter->application_id,
                'list'    => new Application()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'date',
                'label'   => 'date',
                'value'   => old('date') ?? $coverLetter->date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'content',
                'id'      => 'inputEditor',
                'value'   => old('content') ?? $coverLetter->content,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'url',
                'name'      => 'cover letter url',
                'value'     => old('url') ?? $coverLetter->url,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $coverLetter->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $coverLetter->link,
                'name' => old('link_name') ?? $coverLetter->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $coverLetter->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $coverLetter->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $coverLetter->public,
                'readonly'    => old('readonly') ?? $coverLetter->readonly,
                'root'        => old('root')     ?? $coverLetter->root,
                'disabled'    => old('disabled') ?? $coverLetter->disabled,
                'demo'        => old('demo')     ?? $coverLetter->demo,
                'sequence'    => old('sequence') ?? $coverLetter->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.cover-letter.index')
            ])

        </form>

    </div>

@endsection
