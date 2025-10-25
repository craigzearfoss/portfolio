@extends('guest.layouts.default', [
    'title' => $title ?? 'Certification: ' . $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',                      'href' => route('system.homepage') ],
        [ 'name' => $certification->owner->name, 'href' => route('guest.user.index', $certification->owner)],
        [ 'name' => 'Portfolio',                 'href' => route('guest.user.portfolio.index', $certification->owner) ],
        [ 'name' => 'Certifications',            'href' => route('guest.user.portfolio.certification.index', $certification->owner) ],
        [ 'name' => $certification->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.user.portfolio.certification.index', $certification->owner) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $certification->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $certification->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $certification->summary
        ])

        @include('guest.components.show-row', [
            'name'  => 'organization',
            'value' => $certification->organization
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $certification->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'academy',
            'value' => view('guest.components.show-row', [
                            'name'   => $certification->academy['name'],
                            'href'   => $certification->academy['link'],
                            'target' => '_blank',
                        ]),
            'raw'   => true
        ])

        @if(!empty($certification->certificate_url))

            @include('guest.components.show-row-image', [
                'name'     => 'certificate url',
                'src'      => imageUrl($certification->certificate_url),
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certification->name, $certification->certificate_url)
            ])

        @endif

        @if(!empty($certification->link))
            @include('guest.components.show-row-link', [
                'name'   => 'link',
                'href'   => $certification->link,
                'label'  => $certification->link_name,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => $certification->description
        ])

        @if(!empty($certification->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $certification->image,
                'alt'      => $certification->name . ', ' . $certification->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certification->name . '-by-' . $certification->artist, $certification->image)
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $certification->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $certification->image_source
            ])

        @endif

        @if(!empty($certification->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $certification->thumbnail,
                'alt'      => $certification->name . ', ' . $certification->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certification->name . '-by-' . $certification->artist, $certification->thumbnail)
            ])

        @endif

    </div>

@endsection
