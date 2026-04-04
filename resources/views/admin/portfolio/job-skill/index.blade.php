@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Portfolio\JobSkill;

    $title    = $pageTitle ?? (!empty($job) ? $job->company . ' Skills' : 'Job Skills');
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
        $breadcrumbs[] = [ 'name' => 'Skills',   'href' => route('admin.portfolio.job-skill.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'name', 'href' => route('admin.portfolio.job-skill.index') ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobSkill::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Skill', 'href' => route('admin.portfolio.job-skill.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-job-skill', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $jobSkills->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job skill.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>company</th>
                        <th>role</th>
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
                        <th>name</th>
                        <th>company</th>
                        <th>role</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobSkills as $jobSkill)

                    <tr data-id="{{ $jobSkill->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $jobSkill->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            @if($jobSkill->job)
                                {!! $jobSkill->name ?? '' !!}{!! !empty($jobSkill->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                            @endif
                        </td>
                        <td data-field="job.company">
                            @if($jobSkill->job)
                                {!! $jobSkill->job->company ?? '' !!}
                            @endif
                        </td>
                        <td data-field="jo.role">
                            @if($jobSkill->job)
                                {!! $jobSkill->job->role ?? '' !!}
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

                                @if(canRead($jobSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-skill.show', $jobSkill),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($jobSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.job-skill.edit', $jobSkill),
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

                                @if(canDelete($jobSkill, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.job-skill.destroy', $jobSkill) !!}"
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
                        <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No job skills found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $jobSkills->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
