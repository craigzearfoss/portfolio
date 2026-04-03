@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Cover Letter: ' . $coverLetter->name ;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',    'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => $coverLetter->name, 'href' => route('admin.career.cover-letter.show', $coverLetter) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.cover-letter.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

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

            @if($admin->is_root)
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
                'name'    => 'cover_letter_date',
                'label'   => 'date',
                'value'   => old('cover_letter_date') ?? $coverLetter->cover_letter_date,
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
                'is_public'   => old('is_public')   ?? $coverLetter->is_public,
                'is_readonly' => old('is_readonly') ?? $coverLetter->is_readonly,
                'is_root'     => old('is_root')     ?? $coverLetter->root,
                'is_disabled' => old('is_disabled') ?? $coverLetter->is_disabled,
                'is_demo'     => old('is_demo')     ?? $coverLetter->is_demo,
                'sequence'    => old('sequence')    ?? $coverLetter->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.cover-letter.index')
            ])

        </form>

    </div>

@endsection
