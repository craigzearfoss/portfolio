@extends('admin.layouts.default', [
    'title' => !empty($job) ? $job->company . ' Coworkers' : 'Job Coworkers',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index', ['job_id' => $jobId]) ],
        [ 'name' => 'Coworkers' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'href' => route('admin.portfolio.job-coworker.create', ['job_id' => $jobId]) ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                            {{ $jobCoworker->owner['username'] ?? '' }}
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

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job-coworker.show', $jobCoworker->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job-coworker.edit', $jobCoworker->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($jobCoworker->link))
                                <a title="{{ !empty($jobCoworkers->link_name) ? $jobCoworker->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $jobCoworker->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
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
