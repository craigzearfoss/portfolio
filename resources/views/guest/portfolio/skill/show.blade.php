@extends('guest.layouts.default', [
    'title' => $title ?? 'Skill: ' . $skill->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show',$admin) ],
        [ 'name' => 'Skills',     'href' => route('guest.admin.portfolio.skill.index', $admin) ],
        [ 'name' => $skill->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.skill.index', $admin) ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $skill->name
        ])

        @include('guest.components.show-row', [
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
            'value' => $skill->category['name'] ?? ''
        ])

        @if(!empty($skill->start_year))
            @include('admin.components.show-row', [
                'name'  => 'start year',
                'value' => $skill->start_year
            ])
        @endif

        @if(!empty($skill->start_year))
            @include('admin.components.show-row', [
                'name'  => 'years',
                'value' => $skill->years
            ])
        @endif

        @if(!empty($skill->link))
            @include('guest.components.show-row-link', [
                'name'   => $skill->link_name,
                'href'   => $skill->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($skill->description ?? '')
        ])

        @if(!empty($skill->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $skill->image,
                'alt'      => $skill->name . ', ' . $skill->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($skill->name . '-by-' . $skill->artist, $skill->image)
            ])

            @if(!empty($skill->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $skill->image_credit
                ])
            @endif

            @if(!empty($skill->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $skill->image_source
                ])
            @endif

        @endif

        @if(!empty($skill->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $skill->thumbnail,
                'alt'      => $skill->name . ', ' . $skill->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($skill->name . '-by-' . $skill->artist, $skill->thumbnail)
            ])

        @endif

    </div>

@endsection
