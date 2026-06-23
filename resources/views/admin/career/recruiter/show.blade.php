@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recruiter   = $recruiter ?? null;

    $title    = getResourcePageTitle($recruiter);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',      'href' => route('admin.career.recruiter.index') ],
        [ 'name' => getResourcePageTitle($recruiter, false) ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($recruiter, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.recruiter.edit', $recruiter) ])->render();
    }
    if (canCreate($recruiter, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Recruiter',
                                                                  'href' => route('admin.career.recruiter.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.recruiter.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4" style="max-width: 60rem;">

        @if ($isRootAdmin)
            @include('admin.components.favorites-box', [ 'label' => 'favorites', 'count' => $recruiter->favorite_count ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recruiter->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($recruiter->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recruiter->slug
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'primary',
            'checked' => $recruiter->primary
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($recruiter->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'industry',
            'value' => $recruiter->recruiterIndustry['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'specialties',
            'value' => str_replace('|', ', ', $recruiter->specialties)
        ])

        <!-- coverage areas includes local, regional, national, international -->
        @include('admin.components.show-row-coverage-areas', [
            'resource' => $recruiter
        ])

        <?php /*
        // these are displayed in the coverage are row
        @include('admin.components.show-row-checkmark', [
            'name'    => 'local',
            'checked' => $recruiter->local
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'regional',
            'checked' => $recruiter->regional
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'national',
            'checked' => $recruiter->national
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'international',
            'checked' => $recruiter->international
        ])
        */ ?>

        @include('admin.components.show-row', [
            'name'  => 'founded',
            'value' => $recruiter->founded
        ])

        @include('admin.components.show-row', [
            'name'  => 'linkedin url',
            'value' => $recruiter->linkedin_url
                       . (!empty($recruiter->linkedin_url)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $recruiter->linkedin_url,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'jobs url',
            'value' => $recruiter->jobs_url
                       . (!empty($recruiter->jobs_url)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $recruiter->jobs_url,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $recruiter->street,
                           'street2'         => $recruiter->street2,
                           'city'            => $recruiter->city,
                           'state'           => $recruiter->state->code ?? '',
                           'zip'             => $recruiter->zip,
                           'country'         => $recruiter->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $recruiter
        ])

        @include('admin.components.show-row-contact-info', [
            'resource' => $recruiter
        ])

        @include('admin.components.show-row', [
            'name'  => 'link',
            'value' => $recruiter->link
                       . (!empty($recruiter->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $recruiter->link,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $recruiter->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recruiter->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $recruiter,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($recruiter->notes))
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $recruiter,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recruiter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recruiter->updated_at)
        ])

    </div>

@endsection
