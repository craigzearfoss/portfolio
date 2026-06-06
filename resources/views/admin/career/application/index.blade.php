@php
    use App\Models\Career\Application;
    use App\Models\Career\Company;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Application';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Applications' . (!empty($resume) ? ' for ' . $resume->name . ' resume' : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications' ];

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button', [ 'name'  => 'Analyze Job Description',
                                                          'href'  => route('admin.career.application.analyze'),
                                                          'icon'  => 'fa-filter',
                                                          'class' => 'button is-small is-dark my-0 nav-button'
                                                        ])->render();
    if (canCreate(Application::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Application',
                                                                  'href' => route('admin.career.application.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-application', [
        'owner_id' => $isRootAdmin ? null : $owner->id,
        'ignore'   => [ 'active', 'compensation', 'location', 'office', 'type' ]
    ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.application.export', request()->except([ 'page' ])),
                'filename' => 'applications_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($applications->total()) }} {{ ($applications->total() === 1) ? 'application' : 'applications' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $applications->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if ($top_column_headings)
                    <thead>
                    <tr>
                        @if ($isRootAdmin)
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th style="display: none;">
                            @include('admin.components.column-heading', [ 'name'  => 'name' ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'company',
                                'sort' => 'company_name|asc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'role',
                                'sort'  => 'role|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-1400">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'active',
                                'sort'  => 'active|desc',
                            ])
                        </th>
                        <th class="hide-at-1024">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'rating',
                                'sort'  => 'rating|desc',
                            ])
                        </th>
                        <th style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'posted',
                                'sort'  => 'post_date|desc',
                            ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'applied',
                                'sort'  => 'apply_date|desc',
                            ])
                        </th>
                        <th class="hide-at-1024">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'compensation',
                                'sort'  => 'wage_rate|desc',
                            ])
                        </th>
                        <th class="hide-at-1024 has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'wage',
                                'sort'  => 'wage_rate|desc',
                            ])
                        </th>
                        <th style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'duration',
                                'sort'  => 'job_duration_type_id|desc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-1300">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'type',
                                'sort'  => 'job_location_type_id|asc',
                            ])
                        </th>
                        <th class="has-text-centered hide-at-1300">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'office',
                                'sort'  => 'office|asc',
                            ])
                        </th>
                        <th class="hide-at-1400">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'location',
                                'sort'  => 'job_location_type_id|asc',
                            ])
                        </th>
                        <th class="has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'w2',
                                'sort'  => 'w2|desc',
                            ])
                        </th>
                        <th class="has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'relocation',
                                'sort'  => 'relocation|desc',
                            ])
                        </th>
                        <th class="has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'benefits',
                                'sort'  => 'benefits|desc',
                            ])
                        </th>
                        <th class="has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'vacation',
                                'sort'  => 'vacation|desc',
                            ])
                        </th>
                        <th class="has-text-centered" style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'health',
                                'sort'  => 'health|desc',
                            ])
                        </th>
                        <th style="display: none;">
                            @include('admin.components.column-heading', [
                                'class' => $className,
                                'name'  => 'source',
                                'sort'  => 'source|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if ($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if ($isRootAdmin))
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th style="display: none;">name</th>
                        <th>company</th>
                        <th>role</th>
                        <th class="has-text-centered hide-at-1400">active</th>
                        <th class="hide-at-1024">rating</th>
                        <th style="display: none;">posted</th>
                        <th>applied</th>
                        <th class="hide-at-1024">compensation</th>
                        <th class="hide-at-1024 has-text-centered">wage</th>
                        <th style="display: none;">duration</th>
                        <th class="has-text-centered hide-at-1300">type</th>
                        <th class="has-text-centered hide-at-1300">office</th>
                        <th class="hide-at-1400">location</th>
                        <th class="has-text-centered" style="display: none;">w2</th>
                        <th class="has-text-centered" style="display: none;">relo</th>
                        <th class="has-text-centered" style="display: none;">ben</th>
                        <th class="has-text-centered" style="display: none;">vac</th>
                        <th class="has-text-centered" style="display: none;">health</th>
                        <th style="display: none;">source</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($applications as $application)

                    <tr data-id="{{ $application->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $application->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $application->owner->username,
                                    'href' => route('admin.system.admin.show', $application->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap; display: none;">
                            {!! htmlspecialchars($application->name) !!}
                        </td>
                        <td data-field="company.name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => htmlspecialchars($application->company->name ?? ''),
                                'href' => route('admin.career.company.show', $application->company)
                            ])
                        </td>
                        <td data-field="role" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => htmlspecialchars($application->role ?? ''),
                                'href' => route('admin.career.application.show', $application)
                            ])
                        </td>
                        <td data-field="active" class="has-text-centered hide-at-1400">
                            @include('admin.components.checkmark', [ 'checked' => $application->active ])
                        </td>
                        <td data-field="rating" class="has-text-centered hide-at-1024 ">
                            <span class="hide-at-1400">@include('admin.components.star-ratings', [ 'rating' => $application->rating ])</span>
                            <span class="show-at-1400">{{ $application->rating }}</span>
                        </td>
                        <td data-field="post_date" style="white-space: nowrap; display: none;">
                            {{ !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' }}
                        </td>
                        <td data-field="apply_date" style="white-space: nowrap;">
                            {{ !empty($application->apply_date) ? date('M j, Y', strtotime($application->apply_date)) : '' }}
                        </td>
                        <td data-field="compensation" class="hide-at-1024" style="white-space: nowrap;">
                            {{
                                formatCompensation([
                                    'min'   => $application->compensation_min,
                                    'max'   => $application->compensation_max,
                                    'unit'  => $application->compensationUnit->abbreviation ?? '',
                                    'short' => true
                                ])
                            }}
                        </td>
                        <td data-field="wage_rate" class="has-text-centered whitespace-nowrap" style="white-space: nowrap; display: none;">
                            {{ wageRateFormat($application->wage_rate, 0) }}
                        </td>
                        <td data-field="job_duration_id" style="white-space: nowrap; display: none;">
                            {{ $application->durationType['name'] ?? '' }}
                        </td>
                        <td data-field="job_employment_type_id" class="has-text-centered hide-at-1300" style="white-space: nowrap;">
                            {{ $application->employmentType->name ?? '' }}
                        </td>
                        <td data-field="job_location_type_id" class="has-text-centered hide-at-1300" style="white-space: nowrap;">
                            {{ $application->locationType->name ?? '' }}
                        </td>
                        <td data-field="location" class="hide-at-1400">
                            {{
                                formatLocation([
                                    'city'    => htmlspecialchars($application->city),
                                    'state'   => $application->state->code ?? '',
                                ])
                            }}
                        </td>
                        <td data-field="w2" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                        </td>
                        <td data-field="relocation" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                        </td>
                        <td data-field="benefits" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                        </td>
                        <td data-field="vacation" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                        </td>
                        <td data-field="health" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $application->health ])
                        </td>
                        <td data-field="job_board_id" style="display: none;">
                            {!! htmlspecialchars($application->jobBoard->name ?? '') !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($application, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.application.show', ownerParams($application, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($application, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.application.edit', ownerParams($application, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($application->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($application->link_name) ? $application->link_name : 'link',
                                        'href'   => $application->link,
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

                                @if (canDelete($application, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.application.destroy', $application) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '22' : '20' }}">No applications found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $applications->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
