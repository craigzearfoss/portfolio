@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',       'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,   'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',    'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Certificates', 'href' => route('admin.portfolio.certificate.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',    'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Certificates', 'href' => route('admin.portfolio.certificate.index') ];
    }
    $breadcrumbs[] = [ 'name' => $certificate->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $certificate, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.certificate.edit', $certificate)])->render();
    }
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'certificate', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certificate', 'href' => route('admin.portfolio.certificate.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.certificate.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Certificate: ' . $certificate->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $certificate->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $certificate->owner->username
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

        @include('admin.components.show-row-images', [
            'resource' => $certificate,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $certificate->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($certificate->link_name) ? $certificate->link_name : 'link',
            'href'   => $certificate->link
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $certificate->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $certificate->disclaimer
                       ])
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
