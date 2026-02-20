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
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index') ];
    }
    $breadcrumbs[] = [ 'name' => $job->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $job, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.job.edit', $job)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job', 'href' => route('admin.portfolio.job.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job: ' . $job->name,
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

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $job->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $job->owner->username
                ])
            @endif

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

            @include('admin.components.show-row-checkbox', [
                'name'    => 'featured',
                'checked' => $job->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $job->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'start',
                'value' => (!empty($job->start_month) ? date('F', mktime(0, 0, 0, $job->start_month, 10)) : '') . ' ' . $job->start_year
            ])

            @include('admin.components.show-row', [
                'name'  => 'end',
                'value' => (!empty($job->end_month) ? date('F', mktime(0, 0, 0, $job->end_month, 10)) : '') . ' ' . $job->end_year
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
                'name'   => !empty($job->link_name) ? $job->link_name : 'link',
                'href'   => $job->link,
                'target' => '_blank'
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

            @include('admin.portfolio.job.coworker.panel', [
                'coworkers' => $job->coworkers ?? [],
                'job'  => $job
            ])

            @include('admin.portfolio.job.task.panel', [
                'tasks' => $job->tasks ?? [],
                'job'   => $job
            ])

            @include('admin.portfolio.job.skill.panel', [
                'skills' => $job->skills ?? [],
                'job'    => $job
            ])

        </div>
    </div>

@endsection
