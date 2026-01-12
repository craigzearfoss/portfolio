@php
    $breadcrumbs    = [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ,           'href' => route('admin.portfolio.job.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name,  'href' => route('admin.portfolio.job.show', $job->id) ];
        $breadcrumbs[] = [ 'name' => 'Coworkers', 'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'Coworkers', 'href' => route('admin.portfolio.job-coworker.index') ];
    }

    $buttons = [];
    if (canCreate('job-coworker', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => !empty($job) ? $job->company . ' Coworkers' : 'Job Coworkers',
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
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>level</th>
                <th>company</th>
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
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>level</th>
                <th>company</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($jobCoworkers as $jobCoworker)

                <tr data-id="{{ $jobCoworker->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $jobCoworker->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $jobCoworker->name !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->featured ])
                    </td>
                    <td data-field="level">
                        {!! $jobCoworker->level !!}
                    </td>
                    <td data-field="job.company">
                        @if($jobCoworker->job)
                            {!! $jobCoworker->job->company ?? '' !!}
                        @endif
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.job-coworker.destroy', $jobCoworker->id) !!}" method="POST">

                            @if(canRead($jobCoworker))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.job-coworker.show', $jobCoworker->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($jobCoworker))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.job-coworker.edit', $jobCoworker->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($jobCoworker->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($jobCoworker->link_name) ? $jobCoworker->link_name : 'link',
                                    'href'   => $jobCoworker->link,
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

                            @if(canDelete($jobCoworker))
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There are no job coworkers.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobCoworkers->links('vendor.pagination.bulma') !!}

    </div>

@endsection
