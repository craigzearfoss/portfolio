@extends('admin.layouts.default', [
    'title'         => $jobSkill->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',   'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',         'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',              'href' => route('admin.portfolio.job.index') ],
        [ 'name' => $jobTask->job->name, 'href' => route('admin.portfolio.job.show', $jobSkill->job) ],
        [ 'name' => 'Skills',            'href' => route('admin.portfolio.job-skill.index', ['job_id' => $jobSkill->job->id]) ],
        [ 'name' => 'Show' ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.job-skill.edit', $jobSkill) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add Skill', 'href' => route('admin.portfolio.job-skill.create', ['job_id' => $jobSkill->job->id]) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job-skill.index') ],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobSkill->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $jobSkill->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'job',
            'value' =>  view('admin.components.link', [
                'name' => htmlspecialchars($jobSkill->job->name),
                'href' => route('admin.portfolio.job.show', $jobSkill->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'category',
            'value' =>  view('admin.components.link', [
                'name' => htmlspecialchars($jobSkill->category->name ?? ''),
                'href' => route('admin.dictionary.category.show', $jobSkill->job)
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($jobSkill->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'level',
            'value' => htmlspecialchars($jobSkill->level ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $jobSkill->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($jobSkill->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $jobSkill->link_name ?? 'link',
            'href'   => $jobSkill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobSkill->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $jobSkill->disclaimer ?? '' ])
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
