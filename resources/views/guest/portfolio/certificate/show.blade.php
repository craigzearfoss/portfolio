@extends('guest.layouts.default', [
    'title' => $title ?? 'Certificate: ' . $certificate->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',           'href' => route('system.index') ],
        [ 'name' => 'Users',          'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name,     'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',      'href' => route('guest.admin.portfolio.show', $certificate->owner) ],
        [ 'name' => 'Certificates', 'href' => route('guest.admin.portfolio.certificate.index', $certificate->owner) ],
        [ 'name' => $certificate->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.certificate.index', $certificate->owner) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.disclaimer', [ 'value' => $certificate->disclaimer ?? null ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $certificate->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $certificate->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $certificate->summary
        ])

        @include('guest.components.show-row', [
            'name'  => 'organization',
            'value' => $certificate->organization
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $certificate->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'academy',
            'value' => view('guest.components.show-row', [
                            'name'   => $certificate->academy['name'],
                            'href'   => $certificate->academy['link'],
                            'target' => '_blank',
                        ]),
            'raw'   => true
        ])

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
                'name'   => 'link',
                'href'   => $certificate->link,
                'label'  => $certificate->link_name,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => $certificate->description
        ])

        @if(!empty($certificate->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $certificate->image,
                'alt'      => $certificate->name . ', ' . $certificate->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certificate->name . '-by-' . $certificate->artist, $certificate->image)
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => $certificate->image_credit
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => $certificate->image_source
            ])

        @endif

        @if(!empty($certificate->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $certificate->thumbnail,
                'alt'      => $certificate->name . ', ' . $certificate->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($certificate->name . '-by-' . $certificate->artist, $certificate->thumbnail)
            ])

        @endif

    </div>

@endsection
