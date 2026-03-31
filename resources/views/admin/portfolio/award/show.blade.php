@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Award: ' . $award->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Awards',     'href' => route('admin.portfolio.award.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Awards',     'href' => route('admin.portfolio.award.index') ];
    }
    $breadcrumbs[] = [ 'name' => $award->name ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($award, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.award.edit', $award)])->render();
    }
    if (canCreate($award, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Award', 'href' => route('admin.portfolio.award.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.award.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $award->id
            ])

            @if($isRootAdmin)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $award->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $award->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'category',
                'value' => $award->category
            ])

            @include('admin.components.show-row', [
                'name'  => 'nominated work',
                'value' => $award->nominated_work
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $award->slug
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'featured',
                'checked' => $award->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $award->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'year',
                'value' => $award->year
            ])

            @include('admin.components.show-row', [
                'name'  => 'date received',
                'value' => longDate($award->received)
            ])

            @include('admin.components.show-row-images', [
                'resource' => $award,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $award->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $award->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $award->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $award->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $award->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $award,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $award,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($award->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($award->updated_at)
            ])

        </div>
    </div>

@endsection
