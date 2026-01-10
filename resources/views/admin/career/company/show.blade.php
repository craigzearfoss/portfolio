@php
    $buttons = [];
    if (canUpdate($company, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.company.edit', $company) ];
    }
    if (canCreate($company, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Company', 'href' => route('admin.career.company.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.company.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Company: ' . $company->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => $company->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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

                                    @if(isRootAdmin())
                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $company->owner->username ?? ''
                                        ])
                                    @endif

                                    @include('admin.components.show-row', [
                                        'name'  => 'name',
                                        'value' => htmlspecialchars($company->name ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'slug',
                                        'value' => $company->slug
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'industry',
                                        'value' => htmlspecialchars($company->industry['name'] ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'location',
                                        'value' => formatLocation([
                                            'street'          => htmlspecialchars($company->street ?? ''),
                                            'street2'         => htmlspecialchars($company->street2 ?? ''),
                                            'city'            => htmlspecialchars($company->city ?? ''),
                                            'state'           => $company->state->code ?? '',
                                            'zip'             => htmlspecialchars($company->zip ?? ''),
                                            'country'         => $company->country->iso_alpha3 ?? '',
                                            'streetSeparator' => '<br>',
                                        ])
                                    ])

                                    @include('admin.components.show-row-coordinates', [
                                        'resource' => $company
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => htmlspecialchars(!empty($company->phone_label) ? $company->phone_label : 'phone'),
                                        'value' => htmlspecialchars($company->phone ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => htmlspecialchars($company->alt_phone_label ?? 'alt phone'),
                                        'value' => htmlspecialchars($company->alt_phone ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => htmlspecialchars(!empty($company->email_label) ? $company->email_label : 'email'),
                                        'value' => htmlspecialchars($company->email ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => htmlspecialchars(!empty($company->alt_email_label) ? $company->alt_email_label : 'alt email'),
                                        'value' => htmlspecialchars($company->alt_email ?? '')
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'notes',
                                        'value' => $company->notes ?? ''
                                    ])

                                    @include('admin.components.show-row-link', [
                                        'name'   => htmlspecialchars($company->link_name ?? ''),
                                        'href'   => htmlspecialchars($company->link),
                                        'target' => '_blank'
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'description',
                                        'value' => $company->description ?? ''
                                    ])

                                    @include('admin.components.show-row', [
                                        'name'  => 'disclaimer',
                                        'value' => view('admin.components.disclaimer', [
                                                        'value' => htmlspecialchars($company->disclaimer ?? '')
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
