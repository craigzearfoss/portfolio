@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $school      = $school ?? null;

    $title    = getResourcePageTitle($school);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools',         'href' => route('admin.portfolio.school.index') ],
        [ 'name' => getResourcePageTitle($school, false) ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($school, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.portfolio.school.edit', $school) ])->render();
    }
    if (canCreate($school, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New School',
                                                                  'href' => route('admin.portfolio.school.create')
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.school.index') ])->render();

@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $school->id,
                'hide'  => !$isRootAdmin,
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
                'name'  => 'summary',
                'value' => $school->summary
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'active',
                'checked' => $school->active
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'type',
                'checked' => $school->type
            ])

            @include('admin.components.show-row', [
                'name'  => 'details',
                'value' => view('admin.components.partials.school-details', [ 'school' => $school ])
            ])

            @if (!empty($school->former_names))
                @include('admin.components.show-row', [
                    'name'  => 'former names',
                    'value' => str_replace(',', '<br>', $school->former_names)
                ])
            @endif

            @if (!empty($school->nickname))
                @include('admin.components.show-row', [
                    'name'  => 'nickname',
                    'value' => str_replace('|', ', ', $school->nickname)
                ])
            @endif

            @if (!empty($school->mascot))
                @include('admin.components.show-row', [
                    'name'  => 'mascot',
                    'value' => str_replace('|', ', ', $school->mascot)
                ])
            @endif

            @if (!empty($school->colors))
                @include('admin.components.show-row', [
                    'name'  => 'colors',
                    'value' => str_replace('|', ', ', $school->colors)
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'location',
                'value' => formatLocation([
                               'street'          => $school->street,
                               'street2'         => $school->street2,
                               'city'            => $school->city,
                               'state'           => $school->state->code ?? '',
                               'zip'             => $school->zip,
                               'country'         => $school->country->iso_alpha3 ?? '',
                               'separator'       => ', ',
                               'streetSeparator' => ', ',
                           ])
            ])

            @include('admin.components.show-row-coordinates', [
                'resource' => $school
            ])

            @include('admin.components.show-row', [
                'name'  => 'link',
                'value' => $school->link
                           . (!empty($school->link)
                                ? view('admin.components.link-icon', [
                                      'title'  => 'open link in new window',
                                      'href'   => $school->link,
                                      'icon'   => 'fa-external-link',
                                      'border' => false,
                                      'target' => '_blank',
                                      'style'  => [ 'margin-top: -4px' ]
                                  ])
                               : '')
            ])

            @include('admin.components.show-row', [
                'name'  => 'link name',
                'value' => $school->link_name,
            ])

            @include('admin.components.show-row-link', [
                'link_name' => 'wikipedia',
                'name'      => $school->wikipedia,
                'href'      => $school->wikipedia,
                'target'    => '_blank',
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $school->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => htmlspecialchars($school->disclaimer)
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $school,
                'upload'   => true,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => nl2br(htmlspecialchars($school->notes))
            ])

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
