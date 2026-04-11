@php
    use App\Models\Portfolio\Job;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobTask     = $jobTask ?? null;

    $title    = $pageTitle ?? 'Edit Job Task';
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobTask->job) ],
        [ 'name' => 'Tasks',             'href' => route('admin.portfolio.job-task.index', ['job_id' => $jobTask->job->id]) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-task.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job-task.update', array_merge([$jobTask], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job-task.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $jobTask->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a job task */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $jobTask->owner_id
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'job_id',
                'label'     => 'job',
                'value'     => old('job_id') ?? $jobTask->job_id,
                'required'  => true,
                'list'      => new Job()->listOptions([], 'id', 'name', true),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $jobTask->summary,
                'required'  => true,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $jobTask->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $jobTask->link,
                'name' => old('link_name') ?? $jobTask->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $jobTask->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $jobTask->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $jobTask->image,
                'credit'  => old('image_credit') ?? $jobTask->image_credit,
                'source'  => old('image_source') ?? $jobTask->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $jobTask->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $jobTask->is_public,
                'is_readonly' => old('is_readonly') ?? $jobTask->is_readonly,
                'is_root'     => old('is_root')     ?? $jobTask->root,
                'is_disabled' => old('is_disabled') ?? $jobTask->is_disabled,
                'is_demo'     => old('is_demo')     ?? $jobTask->is_demo,
                'sequence'    => old('sequence')    ?? $jobTask->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-task.index')
            ])

        </form>

    </div>

@endsection
