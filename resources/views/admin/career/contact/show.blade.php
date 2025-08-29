@extends('admin.layouts.default', [
    'title' => $contact->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Contacts',        'url' => route('admin.career.contact.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.career.contact.edit', $contact) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Contact', 'url' => route('admin.career.contact.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => route('admin.career.contact.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $contact->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $contact->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $contact->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'street',
            'value' => $contact->street
        ])

        @include('admin.components.show-row', [
            'name'  => 'street2',
            'value' => $contact->street2
        ])

        @include('admin.components.show-row', [
            'name'  => 'city',
            'value' => $contact->city
        ])

        @include('admin.components.show-row', [
            'name'  => 'state',
            'value' => \App\Models\State::getName($contact->state)
        ])

        @include('admin.components.show-row', [
            'name'  => 'zip',
            'value' => $contact->zip
        ])

        @include('admin.components.show-row', [
            'name'  => 'country',
            'value' => \App\Models\Country::getName($contact->country)
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($contact->phone_label) ? $contact->phone_label : 'phone',
            'value' => $contact->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($contact->alt_phone_label) ? $contact->alt_phone_label : 'alt phone',
            'value' => $contact->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($contact->email_label) ? $contact->email_label : 'email',
            'value' => $contact->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($contact->alt_email_label) ? $contact->alt_email_label : 'alt email',
            'value' => $contact->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'website',
            'url'    => $contact->website,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $contact->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $contact->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $contact->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $contact->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($contact->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($contact->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($contact->deleted_at)
        ])

    </div>

@endsection
