@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',      'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,  'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',   'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Photography', 'href' => route('admin.portfolio.photography.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',   'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Photography', 'href' => route('admin.portfolio.photography.index') ];
    }
    $breadcrumbs[] = [ 'name' => $photo->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $photo, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.photography.edit', $photo)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'photography', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Photo', 'href' => route('admin.portfolio.photography.create', ['owner_id'=>$owner->id])])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.photography.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Photography: ' . $photo->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $photo->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $photo->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $photo->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $photo->artist
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $photo->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $photo->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $photo->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $photo->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $photo->credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $photo->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($photo->link_name) ? $photo->link_name : 'link',
            'href'   => $photo->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $photo->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $photo->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $photo,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $photo,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($photo->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($photo->updated_at)
        ])

    </div>

@endsection
