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

            @include('admin.components.show-row', [
                'name'  => 'enrollment',
                'value' => !empty($school->enrollment) ? number_format($school->enrollment): ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'founded',
                'value' => $school->founded
            ])

            @if (!empty($school->closed))
                @include('admin.components.show-row', [
                    'name'  => 'closed',
                    'value' => $school->closed
                ])
            @endif

            @include('admin.components.show-row-checkmark', [
                'name'    => 'public',
                'checked' => $school->public
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'private',
                'checked' => $school->private
            ])

            @if ($school->female && $school->male)
                @include('admin.components.show-row-checkmark', [
                    'name'    => 'coed',
                    'checked' => true
                ])
            @else
                @include('admin.components.show-row-checkmark', [
                    'name'    => 'male',
                    'checked' => $school->male
                ])
                @include('admin.components.show-row-checkmark', [
                    'name'    => 'female',
                    'checked' => $school->female
                ])
            @endif

            @include('admin.components.show-row-checkmark', [
                'name'    => 'community college',
                'checked' => $school->community_college
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'technical',
                'checked' => $school->technical
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'hbcu',
                'checked' => $school->hbcu
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'religious',
                'checked' => $school->religious
            ])

            @if (!empty($school->religious_affiliation))
                @include('admin.components.show-row', [
                    'name'  => 'religious affiliation',
                    'value' => $school->religious_affiliation
                ])
            @endif

            @include('admin.components.show-row-checkmark', [
                'name'    => 'seminary',
                'checked' => $school->seminary
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'medical',
                'checked' => $school->medical
            ])

            @if (!empty($school->former_names))
                @include('admin.components.show-row', [
                    'name'  => 'former names',
                    'value' => $school->former_names
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'nickname',
                'value' => str_replace('|', ', ', $school->nickname)
            ])

            @include('admin.components.show-row', [
                'name'  => 'mascot',
                'value' => str_replace('|', ', ', $school->mascot)
            ])

            @include('admin.components.show-row', [
                'name'  => 'colors',
                'value' => str_replace('|', ', ', $school->colors)
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

            @include('admin.components.show-row-link', [
                'link_name' => htmlspecialchars($school->link_name ?? 'link'),
                'name'      => $school->link,
                'href'      => $school->link,
                'target'    => '_blank',
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
