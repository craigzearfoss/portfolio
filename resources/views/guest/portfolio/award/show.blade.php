@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Award: ' . $award->name . (!empty($award->year) ? ' - ' . $award->year : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $admin) ],
        [ 'name' => 'Award',      'href' => route('guest.portfolio.award.index', $admin) ],
        [ 'name' => $award->name . (!empty($award->year) ? ' - ' . $award->year : '') ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.award.index', $admin) ],
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $award->disclaimer ])

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $award->name
        ])

        @if(!empty($award->category))
            @include('guest.components.show-row', [
                'name'  => 'category',
                'value' => $award->category
            ])
        @endif

        @if(!empty($award->category))
            @include('guest.components.show-row', [
                'name'  => 'nominated_work',
                'value' => $award->nominated_work
            ])
        @endif

        @if(!empty($award->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $award->summary
            ])
        @endif

        @if(!empty($award->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $award->year
            ])
        @endif

        @if(!empty($award->received))
            @include('guest.components.show-row', [
                'name'  => 'date received',
                'value' => $award->received
            ])
        @endif

        @if(!empty($award->organization))
            @include('guest.components.show-row', [
                'name'  => 'organization',
                'value' => $award->organization
            ])
        @endif

        @if(!empty($award->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($award->link_name) ? $award->link_name : 'link',
                'href'   => $award->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($award->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($award->description)
            ])
        @endif

        @if(!empty($award->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $award->image,
                'alt'          => $award->name . ', ' . (!empty($award->year) ? ' - ' . $award->year : ''),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($award->name, $award->image),
                'image_credit' => $award->image_credit,
                'image_source' => $award->image_source,
            ])
        @endif

        @if(!empty($award->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $award->thumbnail,
                'alt'      => $award->name . ', ' . (!empty($award->year) ? ' - ' . $award->year : '') . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug(
                    $award->name . (!empty($award->year) ? ' - ' . $award->year : '') . '-thumbnail',
                    $award->thumbnail
                )
            ])
        @endif

    </div>

@endsection
