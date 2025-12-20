@php
    $buttons = [];
    if (canUpdate($skill, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.skill.edit', $skill) ];
    }
    if (canCreate($skill, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'href' => route('admin.portfolio.skill.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.skill.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Skill: ' . $skill->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills',          'href' => route('admin.portfolio.skill.index') ],
        [ 'name' => $skill->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $skill->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $skill->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($skill->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'version',
            'value' => $skill->version
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $skill->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $skill->summary
        ])

        @include('admin.components.show-row-rating', [
            'name'  => 'level',
            'label' => "({$skill->level} out of 10)",
            'value' => $skill->level
        ])

        @include('admin.components.show-row', [
            'name'  => 'category',
            'value' => $skill->category->name ?? ''
        ])

        @if(!empty($skill->start_year))
            @include('admin.components.show-row', [
                'name'  => 'start year',
                'value' => $skill->start_year
            ])
        @endif

        @if(!empty($skill->end_year))
            @include('admin.components.show-row', [
                'name'  => 'end year',
                'value' => $skill->end_year
            ])
        @endif

        @if(!empty($skill->years))
            @include('admin.components.show-row', [
                'name'  => 'years',
                'value' => $skill->years
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($skill->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $skill->link_name ?? 'link',
            'href'   => $skill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($skill->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $skill->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $skill,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $skill,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($skill->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($skill->updated_at)
        ])

    </div>

@endsection
