@extends('admin.layouts.default', [
    'title' => 'Certificate: ' . $certificate->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certificates',    'href' => route('admin.portfolio.certificate.index') ],
        [ 'name' => $certificate->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'href' => route('admin.portfolio.certificate.edit', $certificate) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certificate', 'href' => route('admin.portfolio.certificate.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'href' => referer('admin.portfolio.certificate.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $certificate->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $certificate->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $certificate->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $certificate->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $certificate->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $certificate->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => $certificate->organization
        ])

        @include('admin.components.show-row', [
            'name' => 'academy',
            'value' => view('admin.components.link', [
                'name' => $certificate->academy['name'] ?? '',
                'href' => !empty($certificate->academy)
                                ? route('admin.portfolio.academy.show', $certificate->academy)
                                : ''
                            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $certificate->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'received',
            'value' => longDate($certificate->received)
        ])

        @include('admin.components.show-row', [
            'name'  => 'expiration',
            'value' => longDate($certificate->expiration)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'certificate url',
            'src'      => imageUrl($certificate->certificate_url),
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certificate->name, $certificate->certificate_url)
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $certificate->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $certificate->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $certificate->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($certificate->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => imageUrl($certificate->image),
            'alt'      => $certificate->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certificate->name, $certificate->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $certificate->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $certificate->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => imageUrl($certificate->thumbnail),
            'alt'      => $certificate->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certificate->name, $certificate->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $certificate->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $certificate->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $certificate->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $certificate->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $certificate->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($certificate->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($certificate->updated_at)
        ])

    </div>

@endsection
