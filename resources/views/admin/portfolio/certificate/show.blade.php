@php
    $buttons = [];
    if (canUpdate($certificate, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.certificate.edit', $certificate) ];
    }
    if (canCreate($certificate, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Certificate', 'href' => route('admin.portfolio.certificate.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.certificate.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Certificate: ' . $certificate->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certificates',    'href' => route('admin.portfolio.certificate.index') ],
        [ 'name' => $certificate->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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
                'value' => $certificate->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($certificate->name)
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
            'value' => htmlspecialchars($certificate->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'organization',
            'value' => htmlspecialchars($certificate->organization)
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

        @include('admin.components.show-row-images', [
            'resource' => $certificate,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($certificate->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $certificate->link_name ?? 'link',
            'href'   => $certificate->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($certificate->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $certificate->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $certificate,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $certificate,
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
