@php
    $title    = $pageTitle ?? 'Project: ' . $project->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Projects',   'href' => route('guest.portfolio.project.index', $owner) ],
        [ 'name' => $project->name ],
    ];

    // set navigation buttons
    $buttons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.project.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $project->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $project->name
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $project->featured
        ])
        */ ?>

        @if(!empty($project->summary ))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $project->summary
            ])
        @endif

        @if(!empty($project->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $project->year
            ])
        @endif

        @if(!empty($project->language))
            @include('guest.components.show-row', [
                'name'  => 'language',
                'value' => $project->language
            ])
        @endif

        @if(!empty($project->language_version))
            @include('guest.components.show-row', [
                'name'  => 'language version',
                'value' => $project->language_version
            ])
        @endif

        @if(!empty($project->repository_url))
            @include('guest.components.show-row-link', [
                'name'   => 'repository',
                'label'  => $project->repository_url,
                'href'   => $project->repository_url,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($project->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($project->link_name) ? $project->link_name : 'link',
                'href'   => $project->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($project->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($project->description)
            ])
        @endif

        @if(!empty($project->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $project->image,
                'alt'          => $project->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($project->name, $project->image),
                'image_credit' => $project->image_credit,
                'image_source' => $project->image_source,
            ])
        @endif

        @if(!empty($project->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $project->thumbnail . ' thumbnail',
                'alt'      => $project->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($project->name . '-thumbnail', $project->thumbnail)
            ])
        @endif

    </div>

@endsection
