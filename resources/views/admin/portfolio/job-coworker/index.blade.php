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
@endphp
@extends('admin.layouts.default', [
    'title'         => !empty($job) ? $job->company . ' Coworkers' : 'Job Coworkers',
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => [
        canCreate('job-coworker')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create') ]]
            : [],
    ],
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
                        {{ $jobCoworker->name }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->featured ])
                    </td>
                    <td data-field="level">
                        {{ $jobCoworker->level }}
                    </td>
                    <td data-field="job.company">
                        @if($jobCoworker->job)
                            {{ $jobCoworker->job['company'] }}
                        @endif
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.job-coworker.destroy', $jobCoworker->id) }}" method="POST">

                            @if(canRead($jobCoworker))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.job-coworker.show', $jobCoworker->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($jobCoworker))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.job-coworker.edit', $jobCoworker->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($jobCoworker->link))
                                <a title="{{ !empty($jobCoworkers->link_name) ? $jobCoworker->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $jobCoworker->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($jobCoworker))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
