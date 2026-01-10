@php
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ,           'href' => route('admin.portfolio.job.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name, 'href' => route('admin.portfolio.job.show', $job->id) ];
        $breadcrumbs[] = [ 'name' => 'Tasks',    'href' => route('admin.portfolio.job-task.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'Tasks', 'href' => route('admin.portfolio.job-task.index') ];
    }

    $buttons = [];
    if (canCreate('job-task', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job Task', 'href' => route('admin.portfolio.job-task.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => !empty($job) ? $job->company . ' Tasks' : 'Job Tasks',
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>summary</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>summary</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($jobTasks as $jobTask)

                <tr data-id="{{ $jobTask->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $jobTask->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="job.company">
                        @if($jobTask->job)
                            {{ htmlspecialchars($jobTask->job['company'] ?? '') }}
                        @endif
                    </td>
                    <td data-field="summary">
                        {{ $jobTask->summary ?? '' }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobTask->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobTask->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{{ route('admin.portfolio.job-task.destroy', $jobTask->id) }}" method="POST">

                            @if(canRead($jobTask))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.job-task.show', $jobTask->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($jobTask))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.job-task.edit', $jobTask->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($jobTask->link))
                                @include('admin.components.link-icon', [
                                    'title'  => htmlspecialchars((!empty($jobTask->link_name) ? $jobTask->link_name : 'link') ?? ''),
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

                            @if(canDelete($jobTask))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no job tasks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobTasks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
