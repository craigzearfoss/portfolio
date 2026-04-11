@php
    use Illuminate\Support\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $job         = $job ?? null;

    $title    = $pageTitle ?? 'Job: ' . $job->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index') ];
    }
    $breadcrumbs[] = [ 'name' => $job->name ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($job, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job.edit', $job)])->render();
    }
    if (canCreate($job, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job', 'href' => route('admin.portfolio.job.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job.index')])->render();
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
                            <li data-target="coworkers">
                                <a>Coworkers</a>
                            </li>
                            <li data-target="tasks">
                                <a>Tasks</a>
                            </li>
                            <li data-target="skills">
                                <a>Skills</a>
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
                                    'value' => $job->id,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'owner',
                                    'value' => $job->owner->username,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'company',
                                    'value' => $job->company
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'role',
                                    'value' => $job->role
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'slug',
                                    'value' => $job->slug
                                ])

                                @include('admin.components.show-row-checkmark', [
                                    'name'    => 'featured',
                                    'checked' => $job->featured
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'summary',
                                    'value' => $job->summary
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'start',
                                    'value' => !empty($job->start_date) ? Carbon::parse($job->start_date)->format("F Y") : ''
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'end',
                                    'value' => !empty($job->end_date) ? Carbon::parse($job->end_date)->format("F Y") : ''
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'employment type',
                                    'value' => $job->employmentType['name'] ?? ''
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'employment location',
                                    'value' => $job->locationType->name ?? ''
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'location',
                                    'value' => formatLocation([
                                                   'street'          => $job->street,
                                                   'street2'         => $job->street2,
                                                   'city'            => $job->city,
                                                   'state'           => $job->state->code ?? '',
                                                   'zip'             => $job->zip,
                                                   'country'         => $job->country->iso_alpha3 ?? '',
                                                   'streetSeparator' => '<br>',
                                               ])
                                ])

                                @include('admin.components.show-row-coordinates', [
                                    'resource' => $job
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $job->notes
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => 'link',
                                    'href'   => $job->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'   => 'link name',
                                    'label'  => 'link_name',
                                    'value'  => $job->link_name,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $job->description
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'disclaimer',
                                    'value' => view('admin.components.disclaimer', [
                                                    'value' => $job->disclaimer
                                               ])
                                ])

                                @include('admin.components.show-row-images', [
                                    'resource' => $job,
                                    'download' => true,
                                    'external' => true,
                                ])

                                @include('admin.components.show-row-visibility', [
                                    'resource' => $job,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'created at',
                                    'value' => longDateTime($job->created_at)
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'updated at',
                                    'value' => longDateTime($job->updated_at)
                                ])

                            </div>
                        </div>

                        <div id="coworkers" class="is-hidden">

                            @include('admin.portfolio.job.coworker.panel', [
                                'coworkers' => $job->coworkers ?? [],
                                'job'  => $job
                            ])

                        </div>

                        <div id="tasks" class="is-hidden">

                            @include('admin.portfolio.job.task.panel', [
                                'tasks' => $job->tasks ?? [],
                                'job'   => $job
                            ])

                        </div>

                        <div id="skills" class="is-hidden">

                            @include('admin.portfolio.job.skill.panel', [
                                'skills' => $job->skills ?? [],
                                'job'    => $job
                            ])

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
