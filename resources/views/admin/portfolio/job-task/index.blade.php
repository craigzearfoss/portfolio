@extends('admin.layouts.default', [
    'title' => !empty($job) ? $job->company . ' Tasks' : 'Job Tasks',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'url' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Tasks' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Task', 'url' => route('admin.portfolio.job-task.create') ],
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
                    <th>admin</th>
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
                    <th>admin</th>
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

            @forelse ($jobTasks as $jobTask)

                <tr data-id="{{ $jobTask->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($jobTask->admin))
                                @include('admin.components.link', [
                                    'name' => $jobTask->admin['username'],
                                    'url'  => route('admin.admin.show', $jobTask->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="job.company">
                        @if($jobTask->job)
                            {{ $jobTask->job['company'] }}
                        @endif
                    </td>
                    <td data-field="summary">
                        {{ $jobTask->summary }}
                    </td>
                    <td data-field="sequence">
                        {{ $jobTask->sequence }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobTask->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobTask->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.job-task.destroy', $jobTask->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job-task.show', $jobTask->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job-task.edit', $jobTask->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($jobTask->link))
                                <a title="{{ !empty($jobTask->link_name) ? $jobTask->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $jobTask->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no job tasks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobTasks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
