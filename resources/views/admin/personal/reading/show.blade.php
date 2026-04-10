@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Reading: ' . $reading->title;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Readings',   'href' => route('admin.personal.reading.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Personal',  'href' => route('admin.personal.index') ];
        $breadcrumbs[] = [ 'name' => 'Readings',  'href' => route('admin.personal.reading.index') ];
    }
    $breadcrumbs[] = [ 'name' => $reading->name ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($reading, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.reading.edit', $reading)])->render();
    }
    if (canCreate($reading, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Reading', 'href' => route('admin.personal.reading.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.reading.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $reading->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $reading->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $reading->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'author',
                'value' => $reading->author
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $reading->slug
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'featured',
                'checked' => $reading->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $reading->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'publication year',
                'value' => $reading->is_publication_year
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'fiction',
                'checked' => $reading->fiction
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'nonfiction',
                'checked' => $reading->nonfiction
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'paper',
                'checked' => $reading->paper
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'audio',
                'checked' => $reading->audio
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'wishlist',
                'checked' => $reading->wishlist
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $reading->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $reading->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $reading->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $reading->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $reading->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $reading,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $reading,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($reading->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($reading->updated_at)
            ])

        </div>
    </div>

@endsection
