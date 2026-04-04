@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;

    $title    = $pageTitle ?? 'Applications' . (!empty($resume) ? ' for ' . $resume->name . ' resume' : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',   'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',   'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Applications' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Application::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Application', 'href' => route('admin.career.application.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-application', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $applications->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if(!empty($admin->is_root))
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
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
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
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $application->owner->username }}
                            </td>
                        @endif
                        <td data-field="name" style="display: none;">
                            {!! $application->name !!}
                        </td>
                        <td data-field="company.name">
                            @if(!empty($application->company))
                                @include('admin.components.link', [
                                    'name' => $application->company->name ?? '',
                                    'href' => route('admin.career.company.show',
                                                    Company::find($application->company->id)
                                                   )
                                ])
                            @endif
                        </td>
                        <td data-field="role">
                            {{ $application->role }}
                        </td>
                        <td data-field="active" class="has-text-centered hide-at-1400">
                            @include('admin.components.checkmark', [ 'checked' => $application->active ])
                        </td>
                        <td data-field="rating" class="has-text-centered hide-at-1024 ">
                            <span class="hide-at-1400">@include('admin.components.star-ratings', [ 'rating' => $application->rating ])</span>
                            <span class="show-at-1400">{{ $application->rating }}</span>
                        </td>
                        <td data-field="post_date" style="white-space: nowrap; display: none;">
                            {!! !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' !!}
                        </td>
                        <td data-field="apply_date" style="white-space: nowrap;">
                            {!! !empty($application->apply_date) ? date('M j, Y', strtotime($application->apply_date)) : '' !!}
                        </td>
                        <td data-field="compensation" class="hide-at-1024">
                            {!!
                                formatCompensation([
                                    'min'   => $application->compensation_min,
                                    'max'   => $application->compensation_max,
                                    'unit'  => $application->compensationUnit->abbreviation ?? '',
                                    'short' => true
                                ])
                            !!}
                        </td>
                        <td data-field="job_duration_id" style="display: none;">
                            {!! $application->durationType['name'] ?? '' !!}
                        </td>
                        <td data-field="job_employment_type_id" class="has-text-centered hide-at-1300">
                            {!! $application->employmentType->name ?? '' !!}
                        </td>
                        <td data-field="job_location_type_id" class="has-text-centered hide-at-1300">
                            {!! $application->locationType->name ?? '' !!}
                        </td>
                        <td data-field="location" class="hide-at-1400">
                            {!!
                                formatLocation([
                                    'city'    => $application->city,
                                    'state'   => $application->state->code ?? '',
                                ])
                            !!}
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
                            {{ $application->jobBoard->name ?? '' }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($application, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.application.show', $application),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($application, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.application.edit', $application),
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

                                @if(canDelete($application, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.application.destroy', $application) !!}"
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
                        <td colspan="{{ $admin->is_root ? '10' : '9' }}">No applications found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $applications->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
