@php
    $breadcrumbs = [
       [ 'name' => 'Home',                    'href' => route('admin.index') ],
       [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
       [ 'name' => 'Portfolio',               'href' => route('admin.portfolio.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => 'Jobs',      'href' => route('admin.portfolio.job.index') ];
        $breadcrumbs[] = [ 'name' => $job->name,  'href' => route('admin.portfolio.job.show', $job->id) ];
        $breadcrumbs[] = [ 'name' => 'Coworkers', 'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $job->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Job Coworkers', 'href' => route('admin.portfolio.job-coworker.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add'];
@endphp
@extends('admin.layouts.default', [
    'title'         =>'Add Job Coworker',
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job-coworker.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job-coworker.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-coworker.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
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

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'level',
                'value'     => old('level') ?? '',
                'required'  => true,
                'list'      => \App\Models\Portfolio\JobCoworker::levelListOptions([], true),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'work_phone',
                'label'     => 'work phone',
                'value'     => old('work_phone') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'personal_phone',
                'label'     => 'personal phone',
                'value'     => old('personal_phone') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'work_email',
                'label'      => 'work email',
                'value'     => old('work_email') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'personal_email',
                'label'     => 'personal email',
                'value'     => old('personal_email') ?? '',
                'maxlength' => 20,
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
                'root'     => old('root') ?? 0,
                'readonly' => old('readonly') ?? 0,
                'root'     => old('root') ?? 0,
                'disabled' => old('disabled') ?? 0,
                'demo'     => old('demo') ?? 0,
                'sequence' => old('sequence') ?? 0,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save Job Coworker',
                'cancel_url' => referer('admin.portfolio.job-coworker.index')
            ])

        </form>

    </div>

@endsection
