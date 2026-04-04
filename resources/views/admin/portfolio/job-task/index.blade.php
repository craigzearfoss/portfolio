@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Portfolio\JobTask;

    $title    = $pageTitle ?? (!empty($job) ? $job->company . ' Tasks' : 'Job Tasks');
    $subtitle = $title;

    // set navigation buttons
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ,           'href' => route('admin.portfolio.job.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name, 'href' => route('admin.portfolio.job.show', $job) ];
        $breadcrumbs[] = [ 'name' => 'Tasks',    'href' => route('admin.portfolio.job-task.index', ['job_id' => $job]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'Tasks', 'href' => route('admin.portfolio.job-task.index') ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobTask::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Task', 'href' => route('admin.portfolio.job-task.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job-task', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $jobTasks->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job task.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>company</th>
                        <th>summary</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>company</th>
                        <th>summary</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobTasks as $jobTask)

                    <tr data-id="{{ $jobTask->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $jobTask->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="job.company">
                            @if($jobTask->job)
                                {!! $jobTask->job->company ?? '' !!}{!! !empty($jobTask->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                            @endif
                        </td>
                        <td data-field="summary">
                            {!! $jobTask->summary !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($jobTask, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-task.show', $jobTask),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($jobTask, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job-task.edit', $jobTask),
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

                                @if(canDelete($jobTask, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.job-task.destroy', $jobTask) !!}"
                                          method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '6' : '5' }}">No job tasks found..</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $jobTasks->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
