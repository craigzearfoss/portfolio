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
        $breadcrumbs[] = [ 'name' => 'Skills',   'href' => route('admin.portfolio.job-skill.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'name', 'href' => route('admin.portfolio.job-skill.index') ];
    }

    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-skill', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Skill', 'href' => route('admin.portfolio.job-skill.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($job) ? $job->company . ' Skills' : 'Job Skills'),
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

    @include('admin.components.search-panel.job-child', [ 'action' => route('admin.portfolio.job-skill.index') ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $jobSkills->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured job skill.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
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
                        <th>name</th>
                        <th>company</th>
                        <th>summary</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobSkills as $jobSkill)

                    <tr data-id="{{ $jobSkill->id }}">
                        @if($admin->root)
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
                        <td data-field="summary">
                            {!! $jobSkill->summary !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobSkill->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobSkill->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $jobSkill, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.job-skill.show', $jobSkill),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $jobSkill, $admin))
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $jobSkill, $admin))
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
                        <td colspan="{{ $admin->root ? '7' : '6' }}">There are no job skills.</td>
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
