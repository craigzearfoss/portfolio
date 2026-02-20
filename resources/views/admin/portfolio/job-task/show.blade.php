@php
    use App\Enums\PermissionEntityTypes;

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $jobTask, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-task.edit', $jobTask)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-task', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Task', 'href' => route('admin.portfolio.job-task.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-task.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job Task',
    'breadcrumbs'      => [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobTask->job) ],
        [ 'name' => 'Tasks',             'href' => route('admin.portfolio.job-task.index', ['job_id' => $jobTask->job->id]) ],
        [ 'name' => 'Show' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $jobTask->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $jobTask->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'job',
                'value' =>  view('admin.components.link', [
                    'name' => $jobTask->job->name ?? '',
                    'href' => route('admin.portfolio.job.show', $jobTask->job)
                ])
            ])

            @include('admin.components.show-row', [
                'name'  => 'company',
                'value' => $jobTask->job->company ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $jobTask->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $jobTask->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => !empty($jobTask->link_name) ? $jobTask->link_name : 'link',
                'href'   => $jobTask->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $jobTask->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $jobTask->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $jobTask,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $jobTask,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($jobTask->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($jobTask->updated_at)
            ])

        </div>
    </div>

@endsection
