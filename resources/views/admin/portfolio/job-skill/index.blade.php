@php
    use App\Models\Portfolio\JobSkill;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\JobSkill';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? (!empty($job) ? $job->company . ' Skills' : 'Job Skills');
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
    $breadcrumbs[] = [ 'name' => 'Skills' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobSkill::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Job Skill',
                                                                  'href' => route('admin.portfolio.job-skill.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job-skill', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.job-skill.export', request()->except([ 'page' ])),
                'filename' => 'job_skills_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($jobSkills->total()) }} {{ ($jobSkills->total() === 1) ? 'job skill' : 'job skills' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobSkills->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job skill.</p>

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
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'company',
                                'sort'  => 'company_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'role',
                                'sort'  => 'role|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobSkills as $jobSkill)

                    <tr data-id="{{ $jobSkill->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $jobSkill->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $jobSkill->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @if ($jobSkill->job)
                                {{ $jobSkill->name ?? '' }}{!! !empty($jobSkill->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                            @endif
                        </td>
                        <td data-field="job.company" style="white-space: nowrap;">
                            @if ($jobSkill->job)
                                {{ $jobSkill->job->company ?? '' }}
                            @endif
                        </td>
                        <td data-field="jo.role">
                            @if ($jobSkill->job)
                                {{ $jobSkill->job->role ?? '' }}
                            @endif
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobSkill->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobSkill->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($jobSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-skill.show', ownerParams($jobSkill, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($jobSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job-skill.edit', ownerParams($jobSkill, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($jobSkill->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($jobSkill->link_name) ? $jobSkill->link_name : 'link',
                                        'href'   => $jobSkill->link,
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

                                @if (canDelete($jobSkill, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.job-skill.destroy', $jobSkill) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '8' : '6' }}">No job skills found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $jobSkills->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
