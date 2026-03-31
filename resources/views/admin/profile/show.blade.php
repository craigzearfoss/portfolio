@php
    $title    = $pageTitle ?? 'My Profile';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'My Profile' ],
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-change-password', ['name' => 'Change Password'])->render(),
        view('admin.components.nav-button-edit', ['href' => route('admin.profile.edit')])->render()
    ];
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
                            <li class="is-active" data-target="overview">
                                <a>Overview</a>
                            </li>
                            <li data-target="emails">
                                <a>Emails</a>
                            </li>
                            <li data-target="phones">
                                <a>Phones</a>
                            </li>
                            <li data-target="teams">
                                <a>Teams</a>
                            </li>
                            <li data-target="groups">
                                <a>Groups</a>
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
                'name'  => 'username',
                'value' => $admin->username,
                'style' => 'white-space: nowrap;',
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $admin->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $admin->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $admin->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($admin->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($admin->updated_at),
                'style' => 'white-space: nowrap;',
            ])

        </div>
        <div class="show-container card floating-div">

            @include('admin.components.show-row-images', [
                'resource' => $admin,
                'download' => true,
                'external' => true,
            ])


                            </div>
                        </div>

                        <div id="phones" class="is-hidden">

                            @include('admin.profile.phone.panel', [
                                'phones' => $admin->phones ?? [],
                                'admin'  => $admin
                            ])

                        </div>

                        <div id="emails" class="is-hidden">

                            @include('admin.profile.email.panel', [
                                'emails' => $admin->emails ?? [],
                                'admin'  => $admin
                            ])

                        </div>

                        <div id="teams" class="is-hidden">
<?php /*
                            @include('admin.career.system.admin-team.panel', [
                                'companies' => $contact->companies ?? [],
                                'contact'   => $contact
                            ])
*/ ?>
                        </div>

                        <div id="groups" class="is-hidden">

                            @include('admin.profile.group.panel', [
                                'groups' => $admin->groups ?? [],
                                'admin'  => $admin
                            ])

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
