@php
    $buttons = [];
    if (canUpdate($company, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.company.edit', $company)])->render();
    }
    if (canCreate('company', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Company', 'href' => route('admin.career.company.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.company.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Company: ' . $company->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => $company->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'loggedInAdmin'    => $loggedInAdmin,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <section class="section">
            <div class="container show-container">
                <div class="columns is-12 is-variable">
                    <div class="column is-12-tablet">

                        <!-- tabbed content -->
                        <div class="tabs is-boxed mb-2">
                            <ul>
                                <li class="is-active" data-target="overview">
                                    <a>Overview</a>
                                </li>
                                <li data-target="contacts">
                                    <a>Contacts</a>
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
                                        'value' => $company->id
                                    ])

                                    @if($admin->root)
                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $company->owner->username
                                        ])
                                    @endif

                                    @include('admin.components.show-row', [
                                        'name'  => 'name',
                                        'value' => $company->name
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'slug',
                                        'value' => $company->slug
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'industry',
                                        'value' => $company->industry['name'] ?? ''
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'location',
                                        'value' => formatLocation([
                                            'street'          => $company->street,
                                            'street2'         => $company->street2,
                                            'city'            => $company->city,
                                            'state'           => $company->state->code ?? '',
                                            'zip'             => $company->zip,
                                            'country'         => $company->country->iso_alpha3 ?? '',
                                            'streetSeparator' => '<br>',
                                        ])
                                    ])

                                    @include('admin.components.show-row-coordinates', [
                                        'resource' => $company
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => !empty($company->phone_label) ? $company->phone_label : 'phone',
                                        'value' => $company->phone
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => $company->alt_phone_label ?? 'alt phone',
                                        'value' => $company->alt_phone
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => !empty($company->email_label) ? $company->email_label : 'email',
                                        'value' => $company->email
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => !empty($company->alt_email_label) ? $company->alt_email_label : 'alt email',
                                        'value' => $company->alt_email
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'notes',
                                        'value' => $company->notes
                                    ])

                                    @include('admin.components.show-row-link', [
                                        'name'   => !empty($company->link_name) ? $company->link_name : '',
                                        'href'   => $company->link,
                                        'target' => '_blank'
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'description',
                                        'value' => $company->description
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'disclaimer',
                                        'value' => view('admin.components.disclaimer', [
                                                        'value' => $company->disclaimer
                                                   ])
                                    ])

                                    @include('admin.components.show-row-images', [
                                        'resource' => $company,
                                        'download' => true,
                                        'external' => true,
                                    ])

                                    @include('admin.components.show-row-settings', [
                                        'resource' => $company,
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'created at',
                                        'value' => longDateTime($company->created_at)
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'updated at',
                                        'value' => longDateTime($company->updated_at)
                                    ])

                                </div>
                            </div>

                            <div id="contacts" class="is-hidden">

                                <div class="card p-4">

                                    <h3 class="is-size-5 title mb-3">Contacts</h3>

                                    <hr class="navbar-divider">
                                    <div style="height: 12px; margin: 0; padding: 0;"></div>

                                    @include('admin.career.company.contact.panel', [
                                        'contacts' => $company->contacts ?? [],
                                        'company'  => $company
                                    ])
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
