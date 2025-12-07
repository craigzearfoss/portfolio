@extends('admin.layouts.default', [
    'title' => 'Contact: ' . $contact->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Contacts',        'href' => route('admin.career.contact.index') ],
        [ 'name' => $contact->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'href' => route('admin.career.contact.edit', $contact) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Contact', 'href' => route('admin.career.contact.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'href' => referer('admin.career.contact.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                'value' => $contact->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($contact->name)
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
            'value' => htmlspecialchars($contact->job_title)
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => htmlspecialchars($contact->street),
                           'street2'         => htmlspecialchars($company->street2),
                           'city'            => htmlspecialchars($contact->city),
                           'state'           => $contact->state->code ?? '',
                           'zip'             => htmlspecialchars($contact->zip),
                           'country'         => $contact->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
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
            'name'  => htmlspecialchars(!empty($contact->phone_label) ? $contact->phone_label : 'phone'),
            'value' => htmlspecialchars($contact->phone)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->alt_phone_label) ? $contact->alt_phone_label : 'alt phone'),
            'value' => htmlspecialchars($contact->alt_phone)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->email_label) ? $contact->email_label : 'email'),
            'value' => htmlspecialchars($contact->email)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($contact->alt_email_label) ? $contact->alt_email_label : 'alt email'),
            'value' => htmlspecialchars($contact->alt_email)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($contact->birthday),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $contact->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($contact->link_name ?? 'link'),
            'href'   => $contact->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($contact->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $contact->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $contact->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($contact->name, $contact->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($contact->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($contact->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $contact->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($contact->name . '-thumb', $contact->thumbnail)
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
            'name'  => 'created at',
            'value' => longDateTime($contact->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($contact->updated_at)
        ])

    </div>

@endsection
