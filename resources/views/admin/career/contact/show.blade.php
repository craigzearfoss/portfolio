@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Contacts',   'href' => route('admin.career.contact.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Contacts',   'href' => route('admin.career.contact.index') ];
    }
    $breadcrumbs[] = [ 'name' => $contact->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $contact, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.contact.edit', $contact)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'contact', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Contact', 'href' => route('admin.career.contact.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.contact.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Contact: ' . $contact->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $contact->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $contact->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $contact->name
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
            'name'  => 'title',
            'value' => $contact->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $contact->street,
                           'street2'         => $company->street2,
                           'city'            => $contact->city,
                           'state'           => $contact->state->code ?? '',
                           'zip'             => $contact->zip,
                           'country'         => $contact->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $contact
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

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($contact->birthday),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $contact->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($contact->link_name) ? $contact->link_name : 'link',
            'href'   => $contact->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $contact->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $contact->disclaimer
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
