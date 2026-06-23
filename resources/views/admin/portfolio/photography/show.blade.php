@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $photo = $photo ?? null;

    $title    = getResourcePageTitle($photo);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                     'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',          'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',  'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',   'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Photography', 'href' => route('admin.portfolio.photography.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($photo, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($photo, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.portfolio.photography.edit', $photo) ])->render();
    }
    if (canCreate($photo, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Photo',
                                                                  'href' => route('admin.portfolio.photography.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.photography.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if ($isRootAdmin)
                @include('admin.components.favorites-box', [ 'label' => 'favorites', 'count' => $photo->favorite_count ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $photo->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $photo->owner->username,
                'hide'  => !$isRootAdmin,
            ])

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

            @include('admin.components.show-row-checkmark', [
                'name'    => 'featured',
                'checked' => $photo->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $photo->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'year',
                'value' => $photo->photo_year
            ])

            @include('admin.components.show-row', [
                'name'  => 'credit',
                'value' => $photo->credit
            ])

            @include('admin.components.show-row', [
                'name'  => 'link',
                'value' => $photo->link
                           . (!empty($photo->link)
                                ? view('admin.components.link-icon', [
                                      'title'  => 'open link in new window',
                                      'href'   => $photo->link,
                                      'icon'   => 'fa-external-link',
                                      'border' => false,
                                      'target' => '_blank',
                                      'style'  => [ 'margin-top: -4px' ]
                                  ])
                               : '')
            ])

            @include('admin.components.show-row', [
                'name'  => 'link name',
                'value' => $photo->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $photo->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => htmlspecialchars($photo->disclaimer)
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $photo,
                'upload'   => true,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($photo->notes))
            ])

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
