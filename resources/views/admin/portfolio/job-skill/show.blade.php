@extends('admin.layouts.default', [
    'title' => $jobSkill->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Skills',          'href' => route('admin.portfolio.job-skill.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'href' => route('admin.portfolio.job-skill.edit', $jobSkill) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-skill.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'href' => referer('admin.portfolio.job-skill.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                'value' => $jobSkill->owner['username'] ?? ''
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
            'name'  => 'company',
            'value' => $jobSkill->job['company'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $jobSkill->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br($jobSkill->notes ?? '')
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $jobSkill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $jobSkill->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($jobSkill->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $jobSkill->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobSkill->name, $jobSkill->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $jobSkill->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $jobSkill->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $jobSkill->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($jobSkill->name . '-thumb', $jobSkill->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $jobSkill->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $jobSkill->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $jobSkill->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $jobSkill->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $jobSkill->disabled
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
