@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Education',        'href' => route('admin.portfolio.education.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Education',        'href' => route('admin.portfolio.education.index') ];
    }
    $breadcrumbs[] = [ 'name' => $education->degreeType->name . ' ' . $education->major ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate($education, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.education.edit', $education)])->render();
    }
    if (canCreate('education', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Education', 'href' => route('admin.portfolio.education.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.education.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Education: ' . $education->degreeType->name . ' ' . $education->major,
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
            'value' => $education->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $education->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'degree type',
            'value' => $education->degreeType->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'major',
            'value' => $education->major
        ])

        @include('admin.components.show-row', [
            'name'  => 'minor',
            'value' => $education->minor
        ])

        @include('admin.components.show-row', [
            'name'  => 'school',
            'value' => $education->school->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $education->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->enrollment_month) ? date('F', mktime(0, 0, 0, $education->enrollment_month, 10)) : '') . ' ' . $education->enrollment_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'graduated',
            'checked' => $education->graduated
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->graduation_month) ? date('F', mktime(0, 0, 0, $education->graduation_month, 10)) : '') . ' ' . $education->graduation_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'currently enrolled',
            'checked' => $education->currently_enrolled
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $education->summary ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $education->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($education->link_name) ? $education->link_name : 'link',
            'href'   => $education->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $education->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $education->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $education,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $education,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($education->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($education->updated_at)
        ])

    </div>

@endsection
