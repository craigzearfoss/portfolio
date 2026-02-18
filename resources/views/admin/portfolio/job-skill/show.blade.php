@php
    use App\Enums\PermissionEntityTypes;

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $jobSkill, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-skill.edit', $jobSkill)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-skill', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Skill', 'href' => route('admin.portfolio.job-skill.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-skill.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? $jobSkill->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobSkill->job) ],
        [ 'name' => 'Skills',            'href' => route('admin.portfolio.job-skill.index', ['job_id' => $jobSkill->job->id]) ],
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

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobSkill->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobSkill->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'job',
            'value' =>  view('admin.components.link', [
                'name' => $jobSkill->job->name,
                'href' => route('admin.portfolio.job.show', $jobSkill->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'category',
            'value' =>  view('admin.components.link', [
                'name' => $jobSkill->category->name,
                'href' => route('admin.dictionary.category.show', $jobSkill->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobSkill->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'level',
            'value' => $jobSkill->level
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $jobSkill->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $jobSkill->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($jobSkill->link_name) ? $jobSkill->link_name : 'link',
            'href'   => $jobSkill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $jobSkill->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $jobSkill->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $jobSkill,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $jobSkill,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobSkill->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobSkill->updated_at)
        ])

    </div>

@endsection
