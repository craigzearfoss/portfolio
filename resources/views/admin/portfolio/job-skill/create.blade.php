@php
    $breadcrumbs = [
       [ 'name' => 'Home',                    'href' => route('admin.index') ],
       [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
       [ 'name' => 'Portfolio',               'href' => route('admin.portfolio.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => 'Jobs',     'href' => route('admin.portfolio.job.index') ];
        $breadcrumbs[] = [ 'name' => $job->name, 'href' => route('admin.portfolio.job.show', $job->id) ];
        $breadcrumbs[] = [ 'name' => 'Skills',   'href' => route('admin.portfolio.job-skill.index', ['job_id' => $job->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Job Skills', 'href' => route('admin.portfolio.job-skill.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add'];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Add Job Skill',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-skill.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job-skill.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-skill.index')
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $job->owner_id ?? '',
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'      => 'job_id',
                'label'     => 'job',
                'value'     => old('job_id') ?? $job->id ?? '',
                'required'  => true,
                'list'      => \App\Models\Portfolio\Job::listOptions([], 'id', 'name', true),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'dictionary_category_id',
                'label'     => 'category',
                'value'     => old('dictionary_category_id') ?? '',
                'required'  => true,
                'list'      => \App\Models\Dictionary\Category::listOptions([], 'id', 'name', true),
                'message'   => $message ?? '',
            ])

            <div style="display: none;">
                @include('admin.components.form-input', [
                    'type'      => 'hidden',
                    'name'      => 'dictionary_term_id',
                    'value'     => old('dictionary_term_id') ?? '',
                    'message'   => $message ?? '',
                ])
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? '',
                'credit'  => old('image_credit') ?? '',
                'source'  => old('image_source') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? 1,
                'readonly' => old('readonly') ?? 0,
                'root'     => old('root') ?? 0,
                'disabled' => old('disabled') ?? 0,
                'demo'     => old('demo') ?? 0,
                'sequence' => old('sequence') ?? 0,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save Job Skill',
                'cancel_url' => referer('admin.portfolio.job-skill.index')
            ])

        </form>

    </div>

@endsection
