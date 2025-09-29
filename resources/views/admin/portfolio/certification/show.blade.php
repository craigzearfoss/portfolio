@extends('admin.layouts.default', [
    'title' => $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',  'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'url' => route('admin.portfolio.certification.edit', $certification) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'url' => route('admin.portfolio.certification.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'url' => referer('admin.portfolio.certification.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $certification->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $certification->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $certification->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $certification->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $certification->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => $certification->organization
        ])

        @include('admin.components.show-row', [
            'name' => 'academy',
            'value' => $certification->academy['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $certification->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'received',
            'value' => longDate($certification->received)
        ])

        @include('admin.components.show-row', [
            'name'  => 'expiration',
            'value' => longDate($certification->expiration)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'certificate url',
            'src'      => imageUrl($certification->certificate_url),
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certification->name, $certification->certificate_url)
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $certification->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $certification->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($certification->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => imageUrl($certification->image),
            'alt'      => $certification->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certification->name, $certification->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $certification->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $certification->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => imageUrl($certification->thumbnail),
            'alt'      => $certification->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($certification->name, $certification->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $certification->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $certification->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $certification->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $certification->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $certification->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($certification->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($certification->updated_at)
        ])

    </div>

@endsection
