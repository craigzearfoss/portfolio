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

    @include('guest.components.disclaimer', [ 'value' => $skill->disclaimer ?? null ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $skill->name
        ])

        @if(!empty($skill->version))
            @include('guest.components.show-row', [
                'name'  => 'version',
                'value' => $skill->version
            ])
        @endif

        <?php /*
        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $skill->featured
        ])
        */ ?>

        @if(!empty($skill->summary))
            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $skill->summary
            ])
        @endif

        @if(!empty($skill->level))
            @include('admin.components.show-row-rating', [
                'name'  => 'level',
                'label' => "({$skill->level} out of 10)",
                'value' => $skill->level
            ])
        @endif

        @if(!empty($skill->category))
            @include('admin.components.show-row', [
                'name'  => 'category',
                'value' => $skill->category->name ?? ''
            ])
        @endif

        @if(!empty($skill->start_year))
            @include('admin.components.show-row', [
                'name'  => 'start year',
                'value' => $skill->start_year
            ])
        @endif

        @php
        if (!empty($skill->years)) {
            $years = $skill->years;
        } elseif (!empty($skill->start_year)) {
            $years = !empty($skill->start_year)
                ? intval($skill->end_year) - intval($skill->start_year) + 1
                : date("Y") - intval($skill->start_year);
        } else {
            $years = '';
        }
        @endphp
        @if(!empty($skill->years))
            @include('admin.components.show-row', [
                'name'  => 'years',
                'value' => $years
            ])
        @endif

        @if(!empty($skill->link))
            @include('guest.components.show-row-link', [
                'name'   => $skill->link_name ?? '',
                'href'   => $skill->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($skill->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => $skill->description
            ])
        @endif

        @if(!empty($skill->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $skill->image,
                'alt'          => $skill->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($skill->name, $skill->image),
                'image_credit' => $skill->image_credit,
                'image_source' => $skill->image_source,
            ])
        @endif

        @if(!empty($skill->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $skill->thumbnail . ' thumbnail',
                'alt'      => $skill->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($skill->name . '-thumbnail', $skill->thumbnail)
            ])
        @endif

    </div>

@endsection
