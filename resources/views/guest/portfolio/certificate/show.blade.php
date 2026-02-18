@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',         'href' => route('guest.index') ],
        [ 'name' => 'Candidates',   'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name,   'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',    'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Certificates', 'href' => route('guest.portfolio.certificate.index', $owner) ],
        [ 'name' => $certificate->name ],
    ];

    // set navigation buttons
    $buttons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.certificate.index', $owner)])->render(),
    ];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Certificate: ' . $certificate->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.disclaimer', [ 'value' => $certificate->disclaimer ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $certificate->name
        ])

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $certificate->featured
        ])
        */ ?>

        @if(!empty($certificate->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $certificate->summary
            ])
        @endif

        @if(!empty($certificate->organization))
            @include('guest.components.show-row', [
                'name'  => 'organization',
                'value' => $certificate->organization
            ])
        @endif

        @if(!empty($certificate->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $certificate->year
            ])
        @endif

        @if(!empty($certificate->link))
            @include('guest.components.show-row', [
                'name'  => 'academy',
                'value' => view('guest.components.show-row', [
                                'name'   => $certificate->academy['name'],
                                'href'   => $certificate->academy['link'],
                                'target' => '_blank',
                            ]),
                'raw'   => true
            ])
        @endif

        @if(!empty($certificate->certificate_url))
            @include('guest.components.show-row-image', [
                'name'     => 'certificate url',
                'src'      => imageUrl($certificate->certificate_url),
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certificate->name, $certificate->certificate_url)
            ])
        @endif

        @if(!empty($certificate->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($certificate->link_name) ? $certificate->link_name : 'link',
                'href'   => $certificate->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($certificate->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($certificate->description)
            ])
        @endif

        @if(!empty($certificate->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $certificate->image,
                'alt'          => $certificate->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($certificate->name, $certificate->image),
                'image_credit' => $certificate->image_credit,
                'image_source' => $certificate->image_source,
            ])
        @endif

        @if(!empty($certificate->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $certificate->thumbnail,
                'alt'      => $certificate->name . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certificate->name . '-thumbnail', $certificate->thumbnail)
            ])
        @endif

    </div>

@endsection
