@php
    use App\Models\Portfolio\JobTask;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\JobTask';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($job) ? $job->company . ' Tasks' : 'Job Tasks');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',    'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Jobs' ,        'href' => route('admin.portfolio.job.index') ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name, 'href' => route('admin.portfolio.job.show', $job) ];
    }
    $breadcrumbs[] = [ 'name' => 'Tasks' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobTask::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Job Task',
                                                                  'href' => route('admin.portfolio.job-task.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job-task', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.job-task.export', request()->except([ 'page' ])),
                'filename' => 'job_tasks_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($jobTasks->total()) }} {{ ($jobTasks->total() === 1) ? 'job task' : 'job tasks' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobTasks->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job task. <span class="sample-color-box-light-gray"></span> indicates the job task is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'company',
                                'sort'  => 'company_name|asc',
                            ])
                        </th>
                        <th></th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'summary',
                                'sort'  => 'summary|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobTasks as $jobTask)

                    <tr data-id="{{ $jobTask->id }}" {!! $jobTask->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $jobTask->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $jobTask->owner->username,
                                    'href'  => route('admin.system.admin.show', $jobTask->owner),
                                    'class' => $jobTask->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="job.company" style="white-space: nowrap;">
                            @if ($jobTask->job)
                                {{ $jobTask->job->company ?? '' }}
                            @endif
                        </td>
                        <td data-field="favorites">
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'portfolio.job_task', 'data-id' => $jobTask->id ]
                           ])
                        </td>
                        <td data-field="summary">
                            {{ $jobTask->summary }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($jobTask, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-task.show', ownerParams($jobTask, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($jobTask, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job-task.edit', ownerParams($jobTask, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($jobTask->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($jobTask->link_name) ? $jobTask->link_name : 'link',
                                        'href'   => $jobTask->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if (canDelete($jobTask, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.job-task.destroy', $jobTask) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '7' : '5' }}">No job tasks found..</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $jobTasks->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
