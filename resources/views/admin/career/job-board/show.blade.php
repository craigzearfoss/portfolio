@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $jobBoard      = $jobBoard ?? null;

    $title    = getResourcePageTitle($jobBoard);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'href' => route('admin.career.job-board.index') ],
        [ 'name' => getResourcePageTitle($jobBoard, false) ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($jobBoard, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.job-board.edit', $jobBoard) ])->render();
    }
    if (canCreate($jobBoard, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Job Board',
                                                                  'href' => route('admin.career.job-board.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.job-board.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4" style="max-width: 60rem;">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $jobBoard->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($jobBoard->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $jobBoard->slug
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'primary',
            'checked' => $jobBoard->primary
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($jobBoard->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'industry',
            'value' => $jobBoard->recruiterIndustry['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'specialties',
            'value' => str_replace('|', ', ', $jobBoard->specialties)
        ])

        @include('admin.components.show-row-job-types', [
            'resource' => $jobBoard,
        ])

        <!-- coverage areas includes local, regional, national, international -->
        @include('admin.components.show-row-coverage-areas', [
            'resource' => $jobBoard
        ])

        @include('admin.components.show-row', [
            'name'  => 'founded',
            'value' => $jobBoard->founded
        ])

        @include('admin.components.show-row', [
            'name'  => 'linkedin url',
            'value' => $jobBoard->linkedin_url
                       . (!empty($jobBoard->linkedin_url)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $jobBoard->linkedin_url,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'jobs url',
            'value' => $jobBoard->jobs_url
                       . (!empty($jobBoard->jobs_url)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $jobBoard->jobs_url,
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
                'street'          => $jobBoard->street,
                'street2'         => $jobBoard->street2,
                'city'            => $jobBoard->city,
                'state'           => $jobBoard->state->code ?? '',
                'zip'             => $jobBoard->zip,
                'country'         => $jobBoard->country->iso_alpha3 ?? '',
                'streetSeparator' => '<br>',
            ])
        ])

        @include('admin.components.show-row-contact-info', [
            'resource' => $jobBoard
        ])

        @include('admin.components.show-row', [
            'name'  => 'link',
            'value' => $jobBoard->link
                       . (!empty($jobBoard->link)
                            ? view('admin.components.link-icon', [
                                  'title'  => 'open link in new window',
                                  'href'   => $jobBoard->link,
                                  'icon'   => 'fa-external-link',
                                  'border' => false,
                                  'target' => '_blank',
                                  'style'  => [ 'margin-top: -4px' ]
                              ])
                           : '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $jobBoard->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $jobBoard->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $jobBoard,
            'upload'   => true,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($jobBoard->notes))
        ])

        @include('admin.components.show-row-job-types', [
            'resource' => $jobBoard,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobBoard->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobBoard->updated_at)
        ])

    </div>

@endsection
