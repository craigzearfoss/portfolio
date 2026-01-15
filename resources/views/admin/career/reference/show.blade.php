@php
    $buttons = [];
    if (canUpdate($reference, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.reference.edit', $reference) ];
    }
    if (canCreate($reference, loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Reference', 'href' => route('admin.career.reference.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.reference.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Reference: ' . $reference->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References',      'href' => route('admin.career.reference.index') ],
        [ 'name' => $reference->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="show-container card form-container p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $reference->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $reference->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $reference->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $reference->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'salutation',
            'value' => $reference->salutation
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $reference->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'relation',
            'value' => $reference->relation
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $reference->company['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                'street'          => $reference->street,
                'street2'         => $reference->street2,
                'city'            => $reference->city,
                'state'           => $reference->state->code ?? '',
                'zip'             => $reference->zip,
                'country'         => $reference->country->iso_alpha3 ?? '',
                'streetSeparator' => '<br>',
            ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $reference
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->phone_label) ? $reference->phone_label : 'phone',
            'value' => $reference->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_phone_label) ? $reference->alt_phone_label : 'alt phone',
            'value' => $reference->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->email_label) ? $reference->email_label : 'email',
            'value' => $reference->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_email_label) ? $reference->alt_email_label : 'alt email',
            'value' => $reference->alt_email
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($reference->birthday),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $reference->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($reference->link_name) ? $reference->link_name : 'link',
            'href'   => $reference->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $reference->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $reference->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $reference,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $reference,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($reference->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($reference->updated_at)
        ])

    </div>

@endsection
