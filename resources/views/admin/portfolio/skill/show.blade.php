@php
    $buttons = [];
    if (canUpdate($skill, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.skill.edit', $skill)])->render();
    }
    if (canCreate('skill', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Skill', 'href' => route('admin.portfolio.skill.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.skill.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Skill: ' . $skill->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills',          'href' => route('admin.portfolio.skill.index') ],
        [ 'name' => $skill->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $skill->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $skill->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $skill->name
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
            'value' => $skill->category->name
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
            'value' => $skill->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($skill->link_name) ? $skill->link_name : 'link',
            'href'   => $skill->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $skill->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $skill->disclaimer
                       ])
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
