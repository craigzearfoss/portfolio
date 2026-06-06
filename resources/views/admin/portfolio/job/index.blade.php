@php
    use App\Models\Portfolio\Job;
    use Illuminate\Support\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Job';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Jobs';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Jobs' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Job::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Job',
                                                                  'href' => route('admin.portfolio.job.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.job.export', request()->except([ 'page' ])),
                'filename' => 'jobs_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($jobs->total()) }} {{ ($jobs->total() === 1) ? 'job' : 'jobs' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobs->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job.</p>

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
                                'sort'  => 'company|asc',
                            ])
                        </th>
                        <th class="has-text-centered">logo</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'role',
                                'sort'  => 'role|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'start',
                                'sort'  => 'start_date|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'end',
                                'sort'  => 'end_date|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobs as $job)

                    <tr data-id="{{ $job->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $job->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $job->owner->username,
                                    'href' => route('admin.system.admin.show', $job->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="company" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $job->company . (!empty($job->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href' => route('admin.portfolio.job.show', $job)
                            ])
                        </td>
                        <td data-field="logo_small" class="has-text-centered">
                            @include('admin.components.image', [
                                'src'   => $job->logo_small,
                                'alt'   => $job->name,
                                'width' => '48px',
                            ])
                        </td>
                        <td data-field="role" style="white-space: nowrap;">
                            {{ $job->role }}
                        </td>
                        <td data-field="start_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($job->start_date) ? Carbon::parse($job->start_date)->format("M Y") : '' }}
                        </td>
                        <td data-field="end_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($job->end_date) ? Carbon::parse($job->end_date)->format("M Y") : '' }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $job->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $job->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($job, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job.show', ownerParams($job, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($job, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job.edit', ownerParams($job, request()->input('owner_id'), $admin)),
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

                                @if (canDelete($job, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.job.destroy', $job) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '10' : '8' }}">No jobs found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $jobs->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
