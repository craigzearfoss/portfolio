@php
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ,           'href' => route('admin.portfolio.job.index') ],
    ];
    if (!empty($job)) {
        $breadcrumbs[] = [ 'name' => $job->name, 'href' => route('admin.portfolio.job.show', $job->id) ];
        $breadcrumbs[] = [ 'name' => 'Skills',   'href' => route('admin.portfolio.job-skill.index', ['job_id' => $job->id]) ];

    } else {
        $breadcrumbs[] = [ 'name' => 'name', 'href' => route('admin.portfolio.job-skill.index') ];
    }

    $buttons = [];
    if (canCreate('job-skill', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job Skill', 'href' => route('admin.portfolio.job-skill.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => !empty($job) ? $job->company . ' Skills' : 'Job Skills',
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
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

            @forelse ($jobSkills as $jobSkill)

                <tr data-id="{{ $jobSkill->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $jobSkill->owner->username ?? '' }}
                        </td>
                    @endif
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.job-skill.destroy', $jobSkill->id) !!}" method="POST">

                            @if(canRead($jobSkill))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.job-skill.show', $jobSkill->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($jobSkill))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.job-skill.edit', $jobSkill->id),
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

                            @if(canDelete($jobSkill))
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
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no job skills.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobSkills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
