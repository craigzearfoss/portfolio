@php
    use App\Models\Career\Recruiter;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Recruiter';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Recruiters';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters' ]
    ];

    // set navigation buttons
    $navButtons = [];
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
                            <li id="initial-selected-tab"  class="is-active" data-target="recruiters">
                                <a>Recruiting Firms</a>
                            </li>
                            <li data-target="contacts">
                                <a>Recruiting Contacts</a>
                            </li>
                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="recruiters" class="is-hidden">

                            @include('admin.career.recruiter.recruiter.panel', [
                                'recruiters' => $recruiters ?? [],
                            ])

                        </div>

                        <div id="contacts" class="is-hidden">

                            @include('admin.career.recruiter.contact.panel', [
                                'contacts' => $contacts ?? [],
                            ])

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
