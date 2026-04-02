@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Contact: ' . $contact->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
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
    $navButtons = [];
    if (canUpdate($contact, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.contact.edit', $contact)])->render();
    }
    if (canCreate($contact, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Contact', 'href' => route('admin.career.contact.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.contact.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <section class="section">
        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-0">
                        <ul style="border-bottom-width: 0 !important;">
                            <li id="initial-selected-tab"  class="is-active" data-target="overview">
                                <a>Overview</a>
                            </li>
                            <li data-target="companies">
                                <a>Companies</a>
                            </li>
                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="overview">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-3">Overview</h3>

                                <hr class="navbar-divider">
                                <div style="height: 12px; margin: 0; padding: 0;"></div>

                                    @include('admin.components.show-row', [
                                        'name'  => 'id',
                                        'value' => $contact->id
                                    ])

                                    @if($admin->is_root)
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

                                    @include('admin.components.show-row', [
                                        'name'  => 'salutation',
                                        'value' => $contact->salutation
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'title',
                                        'value' => $contact->title
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'location',
                                        'value' => formatLocation([
                                                       'street'          => $contact->street,
                                                       'street2'         => $contact->street2,
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
                                    'name'   => 'link',
                                    'href'   => $contact->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'   => 'link name',
                                    'label'  => 'link_name',
                                    'value'  => $contact->link_name,
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

                                    @include('admin.components.show-row-visibility', [
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
                        </div>

                        <div id="companies" class="is-hidden">

                            @include('admin.career.contact.company.panel', [
                                'companies' => $contact->companies ?? [],
                                'contact'   => $contact
                            ])

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
