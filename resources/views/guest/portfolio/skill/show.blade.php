@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Skill: ' . $skill->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index',$owner) ],
        [ 'name' => 'Skills',     'href' => route('guest.portfolio.skill.index', $owner) ],
        [ 'name' => $skill->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.skill.index', $owner)])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $skill->disclaimer ])

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
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $skill->featured
        ])
        */ ?>

        @if(!empty($skill->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $skill->summary
            ])
        @endif

        @if(!empty($skill->level))
            @include('guest.components.show-row-rating', [
                'name'  => 'level',
                'label' => "({$skill->level} out of 10)",
                'value' => $skill->level
            ])
        @endif

        @if(!empty($skill->category))
            @include('guest.components.show-row', [
                'name'  => 'category',
                'value' => $skill->category->name
            ])
        @endif

        @if(!empty($skill->start_year))
            @include('guest.components.show-row', [
                'name'  => 'start year',
                'value' => $skill->start_year
            ])
        @endif

        @php
        if (!empty($skill->years)) {
            $years = $skill->years;
        } elseif (!empty($skill->start_year)) {
            $years = !empty($skill->end_year)
                ? intval($skill->end_year) - intval($skill->start_year) + 1
                : date("Y") - intval($skill->start_year);
        } else {
            $years = '';
        }
        @endphp
        @if(!empty($skill->years))
            @include('guest.components.show-row', [
                'name'  => 'years',
                'value' => $years
            ])
        @endif

        @if(!empty($skill->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($skill->link_name) ? $skill->link_name : 'link',
                'href'   => $skill->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($skill->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($skill->description)
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
