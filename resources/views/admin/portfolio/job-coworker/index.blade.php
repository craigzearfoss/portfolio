@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? (!empty($job) ? $job->company . ' Coworkers' : 'Job Coworkers');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs    = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ,           'href' => route('admin.portfolio.job.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name,  'href' => route('admin.portfolio.job.show', $job) ];
        $breadcrumbs[] = [ 'name' => 'Coworkers', 'href' => route('admin.portfolio.job-coworker.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'Coworkers', 'href' => route('admin.portfolio.job-coworker.index') ];
    }

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-coworker', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.job-child', [ 'action' => route('admin.portfolio.job-coworker.index') ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $jobCoworkers->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured coworker.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>level</th>
                    <th>company</th>
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
                        <th>name</th>
                        <th>level</th>
                        <th>company</th>
                        <th class="has-text-centered">featured</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobCoworkers as $jobCoworker)

                    <tr data-id="{{ $jobCoworker->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $jobCoworker->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $jobCoworker->name !!}{!! !empty($jobCoworker->featured) ? '<span class="featured-splat">*</span>' : '' !!}
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
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $jobCoworker, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-coworker.show', $jobCoworker),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $jobCoworker, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job-coworker.edit', $jobCoworker),
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $jobCoworker, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.job-coworker.destroy', $jobCoworker) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '7' : '6' }}">There are no job coworkers.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $jobCoworkers->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
