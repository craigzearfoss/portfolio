@extends('guest.layouts.default', [
    'title' => $title ?? 'Project: ' . $project->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Projects',   'href' => route('guest.admin.portfolio.project.index', $admin) ],
        [ 'name' => $project->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.project.index', $admin) ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $project->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $project->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $project->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'language',
            'value' => $project->language
        ])

        @include('guest.components.show-row', [
            'name'  => 'language version',
            'value' => $project->language_version
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'repository',
            'label'  => $project->repository_name,
            'href'   => $project->repository_url,
            'target' => '_blank'
        ])

        @if(!empty($project->link))
            @include('guest.components.show-row-link', [
                'name'   => $project->link_name,
                'href'   => $project->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($project->description ?? '')
        ])

        @if(!empty($project->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $project->image,
                'alt'      => $project->name . ', ' . $project->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($project->name . '-by-' . $project->artist, $project->image)
            ])

            @if(!empty($project->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $project->image_credit
                ])
            @endif

            @if(!empty($project->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $project->image_source
                ])
            @endif

        @endif

        @if(!empty($project->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $project->thumbnail,
                'alt'      => $project->name . ', ' . $project->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($project->name . '-by-' . $project->artist, $project->thumbnail)
            ])

        @endif

    </div>

@endsection
