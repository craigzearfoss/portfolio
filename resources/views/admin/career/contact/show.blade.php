@php
    $buttons = [];
    if (canUpdate($contact, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.contact.edit', $contact) ];
    }
    if (canCreate($contact, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Contact', 'href' => route('admin.career.contact.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.contact.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Contact: ' . $contact->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Contacts',        'href' => route('admin.career.contact.index') ],
        [ 'name' => $contact->name ],
    ],
    'buttons'       => $butons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $contact->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $contact->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($contact->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $contact->slug
        ])

        @include('admin.career.contact.company.panel', [
            'companies' => $contact->companies ?? [],
            'contact'   => $contact
        ])

        @include('admin.components.show-row', [
            'name'  => 'job title',
            'value' => htmlspecialchars($contact->job_title ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($contact->street ?? ''),
                           'street2'         => htmlspecialchars($company->street2 ?? ''),
                           'city'            => htmlspecialchars($contact->city ?? ''),
                           'state'           => $contact->state->code ?? '',
                           'zip'             => htmlspecialchars($contact->zip ?? ''),
                           'country'         => $contact->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $contact
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->phone_label) ? $contact->phone_label : 'phone'),
            'value' => htmlspecialchars($contact->phone ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->alt_phone_label) ? $contact->alt_phone_label : 'alt phone'),
            'value' => htmlspecialchars($contact->alt_phone ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->email_label) ? $contact->email_label : 'email'),
            'value' => htmlspecialchars($contact->email ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->alt_email_label) ? $contact->alt_email_label : 'alt email'),
            'value' => htmlspecialchars($contact->alt_email ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($contact->birthday),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $contact->notes ?? ''
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($contact->link_name ?? 'link'),
            'href'   => htmlspecialchars($contact->link),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $contact->description ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => htmlspecialchars($contact->disclaimer ?? '')
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $contact,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $contact,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($contact->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($contact->updated_at)
        ])

    </div>

@endsection
