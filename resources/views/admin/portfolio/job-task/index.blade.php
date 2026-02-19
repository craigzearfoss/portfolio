@php
    use App\Enums\PermissionEntityTypes;

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

    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-task', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Task', 'href' => route('admin.portfolio.job-task.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($job) ? $job->company . ' Tasks' : 'Job Tasks'),
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

    @include('admin.components.search-panel.job-child', [ 'action' => route('admin.portfolio.job-task.index') ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $jobTasks->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job task.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>company</th>
                    <th>summary</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
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
                        @if($admin->root)
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
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobTask->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $jobTask, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-task.show', $jobTask),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $jobTask, $admin))
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $jobTask, $admin))
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
                        <td colspan="{{ $admin->root ? '6' : '5' }}">There are no job tasks.</td>
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
