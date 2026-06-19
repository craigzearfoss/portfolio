@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $company       = $company ?? null;

    $title    = getResourcePageTitle($company);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Companies',  'href' => route('admin.career.company.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($company, false) ];

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button-edit', [
        'name' => 'Apply to Company',
        'href' => route('admin.career.application.create', [ 'company_id' => $company->id ])
    ])->render();
    if (canUpdate($company, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.company.edit', $company) ])->render();
    }
    if (canCreate($company, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Company',
                                                                  'href' => route('admin.career.company.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.company.index') ])->render();
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
                            <li data-target="contacts">
                                <a>Contacts</a>
                            </li>
                            <li data-target="applications">
                                <a>Applications</a>
                            </li>
                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="overview">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-3">Overview</h3>

                                <hr class="navbar-divider">
                                <div style="height: 12px; margin: 0; padding: 0;"></div>

                                <div class="floating-div-container">

                                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

                                        @include('admin.components.show-row', [
                                            'name'  => 'id',
                                            'value' => $company->id,
                                            'hide'  => !$isRootAdmin,
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $company->owner->username,
                                            'hide'  => !$isRootAdmin,
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => htmlspecialchars($company->name)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $company->slug
                                        ])

                                    </div>
                                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

                                        @include('admin.components.show-row', [
                                            'name'  => 'industry',
                                            'value' => htmlspecialchars($company->industry['name'] ?? '')
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'founded',
                                            'value' => $company->founded
                                        ])

                                    </div>
                                </div>
                                <div class="floating-div-container">

                                    @include('admin.components.show-contact-card', [
                                        'resource' => $company
                                    ])

                                </div>
                                <div class="floating-div-container">

                                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 100%;">

                                        @include('admin.components.show-row-link', [
                                            'link_name' => 'link',
                                            'name'      => $company->link,
                                            'href'      => $company->link,
                                            'target'    => '_blank',
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'link name',
                                            'value' => $company->link_name,
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $company->description
                                        ])

                                    </div>
                                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 100%;">

                                        @include('admin.components.show-row', [
                                            'name'  => 'disclaimer',
                                            'value' => view('admin.components.disclaimer', [
                                                            'value' => htmlspecialchars($company->disclaimer)
                                                       ])
                                        ])

                                        @include('admin.components.show-row-images', [
                                            'resource' => $company,
                                            'upload'   => true,
                                            'download' => true,
                                            'external' => true,
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'notes',
                                            'value' =>  nl2br(htmlspecialchars($company->notes))
                                        ])

                                        @include('admin.components.show-row-visibility', [
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

                            </div>

                        </div>

                        <div id="contacts" class="is-hidden">

                            @include('admin.career.company.contact.panel', [
                                'contacts' => $company->contacts ?? [],
                                'company'  => $company
                            ])

                        </div>

                        <div id="applications" class="is-hidden">

                            @include('admin.career.company.application.panel', [
                                'applications' => $company->applications ?? [],
                                'company'      => $company
                            ])

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
