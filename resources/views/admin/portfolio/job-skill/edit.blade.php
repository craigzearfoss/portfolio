@extends('admin.layouts.default', [
    'title' => 'Job Skill Edit',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Skills',          'href' => route('admin.portfolio.job-skill.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job-skill.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job-skill.update', $jobSkill) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-skill.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $jobSkill->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $jobSkill->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $jobSkill->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $jobSkill->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'level',
                'label'       => 'level (1 to 10)',
                'value'       => old('level') ?? $jobSkill->level,
                'min'         => 1,
                'max'         => 10,
                'required'    => true,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'dictionary_category_id',
                'label'     => 'category',
                'value'     => old('job_id') ?? $jobSkill->dictionary_category_id,
                'required'  => true,
                'list'      => \App\Models\Dictionary\Category::listOptions([], 'id', 'name', true),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input', [
                'type'      => 'hidden',
                'name'      => 'dictionary_term_id',
                'value'     => old('dictionary_term_id') ?? $jobSkill->dictionary_term_id,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'start_year',
                'label'     => 'start year',
                'value'     => old('start_year') ?? $jobSkill->start_year,
                'min'       => 1950,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'end_year',
                'label'     => 'end year',
                'value'     => old('end_year') ?? $jobSkill->start_year,
                'min'       => 1950,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'years',
                'value'     => old('years') ?? $jobSkill->years,
                'min'       => 0,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $jobSkill->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $jobSkill->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $jobSkill->link,
                'name' => old('link_name') ?? $jobSkill->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $jobSkill->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $jobSkill->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $jobSkill->link,
                'name' => old('link_name') ?? $jobSkill->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $jobSkill->image,
                'credit'  => old('image_credit') ?? $jobSkill->image_credit,
                'source'  => old('image_source') ?? $jobSkill->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $jobSkill->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $jobSkill->public,
                'readonly' => old('readonly') ?? $jobSkill->readonly,
                'root'     => old('root') ?? $jobSkill->root,
                'disabled' => old('disabled') ?? $jobSkill->disabled,
                'demo'     => old('demo') ?? $jobSkill->demo,
                'sequence' => old('sequence') ?? $jobSkill->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-skill.index')
            ])

        </form>

    </div>

@endsection
