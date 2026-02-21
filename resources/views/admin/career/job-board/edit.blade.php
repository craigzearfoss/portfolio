@php
    $title = $pageTitle ?? (!empty($title) ? $title : 'Job Board: ' . $jobBoard->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'href' => route('admin.career.job-board.index') ],
        [ 'name' => $jobBoard->name,   'href' => route('admin.career.job-board.show', $jobBoard) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.job-board.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.job-board.update', array_merge([$jobBoard], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.job-board.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $jobBoard->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $jobBoard->name,
                'required'  => true,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'primary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('primary') ?? $jobBoard->primary,
                'message'         => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field" style="flex-grow: 0;">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'local',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('local') ?? $jobBoard->local,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'regional',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('regional') ?? $jobBoard->regional,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'national',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('national') ?? $jobBoard->national,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'international',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('international') ?? $jobBoard->international,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $jobBoard->link,
                'name' => old('link_name') ?? $jobBoard->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $jobBoard->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $jobBoard->image,
                'credit'  => old('image_credit') ?? $jobBoard->image_credit,
                'source'  => old('image_source') ?? $jobBoard->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $jobBoard->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $jobBoard->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $jobBoard->public,
                'readonly'    => old('readonly') ?? $jobBoard->readonly,
                'root'        => old('root')     ?? $jobBoard->root,
                'disabled'    => old('disabled') ?? $jobBoard->disabled,
                'demo'        => old('demo')     ?? $jobBoard->demo,
                'sequence'    => old('sequence') ?? $jobBoard->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.job-board.index')
            ])

        </form>

    </div>

@endsection
