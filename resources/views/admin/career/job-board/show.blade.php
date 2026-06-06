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

    <div class="show-container card p-4">

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

        @include('admin.components.show-row-job-board-types', [
            'resource' => $jobBoard,
        ])

        @include('admin.components.show-row', [
            'name'  => 'coverage area',
            'value' => implode(', ', $jobBoard->coverageAreas ?? [])
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'local',
            'checked' => $jobBoard->local
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'regional',
            'checked' => $jobBoard->regional
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'national',
            'checked' => $jobBoard->national
        ])

        @include('admin.components.show-row-checkmark', [
            'name'    => 'international',
            'checked' => $jobBoard->international
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

        @include('admin.components.show-row', [
            'name'  => !empty($jobBoard->phone_label) ? htmlspecialchars($jobBoard->phone_label) : 'phone',
            'value' => htmlspecialchars($jobBoard->phone)
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($jobBoard->alt_phone_label) ? htmlspecialchars($jobBoard->alt_phone_label) : 'phone',
            'value' => htmlspecialchars($jobBoard->alt_phone)
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($jobBoard->email_label) ? htmlspecialchars($jobBoard->email_label) : 'email',
            'value' => htmlspecialchars($jobBoard->email)
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($jobBoard->alt_email_label) ? htmlspecialchars($jobBoard->alt_email_label) : 'alt email',
            'value' => htmlspecialchars($jobBoard->alt_email)
        ])

        @include('admin.components.show-row-link', [
            'link_name' => htmlspecialchars($jobBoard->link_name ?? 'link'),
            'name'      => $jobBoard->link,
            'href'      => $jobBoard->link,
            'target'    => '_blank',
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

        @include('admin.components.show-row-visibility', [
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
