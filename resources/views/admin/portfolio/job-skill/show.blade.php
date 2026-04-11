@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;
    $jobSkill    = $jobSkill ?? null;

    $title    = $pageTitle ?? $jobSkill->name;
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',              'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobSkill->job->name, 'href' => route('admin.portfolio.job.show', $jobSkill->job) ],
        [ 'name' => 'Skills',            'href' => route('admin.portfolio.job-skill.index', ['job_id' => $jobSkill->job->id]) ],
        [ 'name' => 'Show' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($jobSkill, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job-skill.edit', $jobSkill)])->render();
    }
    if (canCreate($jobSkill, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Skill', 'href' => route('admin.portfolio.job-skill.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job-skill.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $jobSkill->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobSkill->owner->username,
                'hide'  => !$isRootAdmin,
            ])

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
                'name'   => 'link',
                'href'   => $jobSkill->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $jobSkill->link_name,
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

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
