@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $antiSkill   = $antiSkill ?? null;

    $title    = getResourcePageTitle($antiSkill);
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
    $breadcrumbs[] = [ 'name' => 'Anti Skills', 'href' => route('admin.portfolio.anti-skill.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($antiSkill, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($antiSkill, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.portfolio.anti-skill.edit', $antiSkill) ])->render();
    }
    if (canCreate($antiSkill, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Skill',
                                                                  'href' => route('admin.portfolio.anti-skill.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.anti-skill.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $antiSkill->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $antiSkill->owner->username,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $antiSkill->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'version',
                'value' => $antiSkill->version
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'featured',
                'checked' => $antiSkill->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $antiSkill->summary
            ])

            @include('admin.components.show-row-rating', [
                'name'  => 'level',
                'label' => "({$antiSkill->level} out of 10)",
                'value' => $antiSkill->level
            ])

            @include('admin.components.show-row', [
                'name'  => 'category',
                'value' => $antiSkill->category->name
            ])

            @if (!empty($antiSkill->start_year))
                @include('admin.components.show-row', [
                    'name'  => 'start year',
                    'value' => $antiSkill->start_year
                ])
            @endif

            @if (!empty($antiSkill->end_year))
                @include('admin.components.show-row', [
                    'name'  => 'end year',
                    'value' => $antiSkill->end_year
                ])
            @endif

            @if (!empty($antiSkill->years))
                @include('admin.components.show-row', [
                    'name'  => 'years',
                    'value' => $antiSkill->years
                ])
            @endif

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $antiSkill->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $antiSkill->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $antiSkill->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => htmlspecialchars($antiSkill->disclaimer)
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $antiSkill,
                'upload'   => true,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($antiSkill->notes))
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $antiSkill,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($antiSkill->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($antiSkill->updated_at)
            ])

        </div>
    </div>

@endsection
