@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools',         'href' => route('admin.portfolio.school.index') ],
        [ 'name' => $school->name ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $school, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.school.edit', $school)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'school', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New School', 'href' => route('admin.portfolio.school.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.school.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'School: ' . $school->name,
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
            'value' => $school->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $school->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $school->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => $school->enrollment
        ])

        @include('admin.components.show-row', [
            'name'  => 'founded',
            'value' => $school->founded
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $school->street,
                           'street2'         => $school->street2,
                           'city'            => $school->city,
                           'state'           => $school->state->code ?? '',
                           'zip'             => $school->zip,
                           'country'         => $school->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $school
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $school->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !(empty($school->link_name)) ? $school->link_name : 'link',
            'href'   => $school->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $school->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $school->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $school,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $school,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($school->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($school->updated_at)
        ])

    </div>

@endsection
