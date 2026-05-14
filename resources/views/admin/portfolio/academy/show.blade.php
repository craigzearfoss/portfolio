@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $academy     = $academy ?? null;

    $title    = getResourcePageTitle($academy);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'href' => route('admin.portfolio.academy.index') ],
        [ 'name' => getResourcePageTitle($academy, false) ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($academy, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.portfolio.academy.edit', $academy) ])->render();
    }
    if (canCreate($academy, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Academy',
                                                                  'href' => route('admin.portfolio.academy.create')
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.academy.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $academy->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $academy->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $academy->slug
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'primary',
                'checked' => $academy->primary
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $academy->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'location',
                'value' => formatLocation([
                    'street'          => $academy->street,
                    'street2'         => $academy->street2,
                    'city'            => $academy->city,
                    'state'           => $academy->state->code ?? '',
                    'zip'             => $academy->zip,
                    'country'         => $academy->country->iso_alpha3 ?? '',
                    'streetSeparator' => '<br>',
                ])
            ])

            @include('admin.components.show-row', [
                'name'  => !empty($academy->phone_label) ? $academy->phone_label : 'phone',
                'value' => $academy->phone
            ])

            @include('admin.components.show-row', [
                'name'  => $academy->alt_phone_label ?? 'alt phone',
                'value' => $academy->alt_phone
            ])

            @include('admin.components.show-row', [
                'name'  => !empty($academy->email_label) ? $academy->email_label : 'email',
                'value' => $academy->email
            ])

            @include('admin.components.show-row', [
                'name'  => !empty($academy->alt_email_label) ? $academy->alt_email_label : 'alt email',
                'value' => $academy->alt_email
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $academy->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $academy->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $academy->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $academy->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $academy,
                'upload'   => true,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $academy->notes
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $academy,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($academy->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($academy->updated_at)
            ])

        </div>
    </div>

@endsection
