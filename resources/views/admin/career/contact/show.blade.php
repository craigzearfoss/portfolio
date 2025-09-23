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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => referer('admin.career.contact.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

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
            'name'  => 'job_title',
            'label' => 'job title',
            'value' => $contact->job_title
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'    => $contact->street ?? null,
                           'street2'   => $company->street2 ?? null,
                           'city'      => $contact->city ?? null,
                           'state'     => $contact->state['code'] ?? null,
                           'zip'       => $contact->zip ?? null,
                           'country'   => $contact->country['iso_alpha3'] ?? null,
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $contact->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $contact->longitude
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
            'name'   => 'link',
            'url'    => $contact->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $contact->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $contact->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $contact->image,
            'alt'   => $contact->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $contact->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $contact->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $contact->thumbnail,
            'alt'   => $contact->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $contact->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $contact->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $contact->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $contact->root
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

    </div>

@endsection
