@php
    use App\Models\Portfolio\Job;
    use Illuminate\Support\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Jobs';
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
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Jobs' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Job::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job', 'href' => route('admin.portfolio.job.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $jobs->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>company</th>
                        <th>logo</th>
                        <th>role</th>
                        <th class="has-text-centered">start</th>
                        <th class="has-text-centered">end</th>
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
                        <th>logo</th>
                        <th>role</th>
                        <th class="has-text-right">start</th>
                        <th class="has-text-right">end</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobs as $job)

                    <tr data-id="{{ $job->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $job->owner->username }}
                            </td>
                        @endif
                        <td data-field="company">
                            {!! $job->company !!}{!! !empty($job->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="logo_small">
                            @include('admin.components.image', [
                                'src'   => $job->logo_small,
                                'alt'   => $job->name,
                                'width' => '48px',
                            ])
                        </td>
                        <td data-field="role">
                            {!! $job->role !!}
                        </td>
                        <td data-field="start_date" class="has-text-right" style="white-space: nowrap;">
                            {{ !empty($job->start_date) ? Carbon::parse($job->start_date)->format("M j, Y") : '' }}
                        </td>
                        <td data-field="end_date" class="has-text-right" style="white-space: nowrap;">
                            {{ !empty($job->end_date) ? Carbon::parse($job->end_date)->format("M j, Y") : '' }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $job->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $job->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($job, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job.show', $job),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($job, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job.edit', $job),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($job->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($job->link_name) ? $job->link_name : 'link',
                                        'href'   => $job->link,
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

                                @if(canDelete($job, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.job.destroy', $job) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '9' : '8' }}">No jobs found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $jobs->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
