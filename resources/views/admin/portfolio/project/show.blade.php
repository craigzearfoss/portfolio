@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Project: ' . $project->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Projects',   'href' => route('admin.portfolio.project.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Projects',   'href' => route('admin.portfolio.project.index') ];
    }
    $breadcrumbs[] = [ 'name' => $project->name ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $project, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.project.edit', $project)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'project', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Project', 'href' => route('admin.portfolio.project.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.project.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $project->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $project->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $project->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $project->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $project->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $project->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'language',
            'value' => $project->language
        ])

        @include('admin.components.show-row', [
            'name'  => 'language version',
            'value' => $project->language_version
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'repository',
            'href'    => $project->repository_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'repository name',
            'value' => $project->repository_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $project->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($project->link_name) ? $project->link_name : 'link',
            'href'   => $project->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $project->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $project->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $project,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $project,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($project->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($project->updated_at)
        ])

    </div>

@endsection
