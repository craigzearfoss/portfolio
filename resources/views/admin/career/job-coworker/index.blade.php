@extends('admin.layouts.default', [
    'title' => !empty($job) ? $job->company . ' Coworkers' : 'Job Coworkers',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'url' => route('admin.career.job.index', ['job_id' => $jobId]) ],
        [ 'name' => 'Coworkers' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Coworker', 'url' => route('admin.career.job-coworker.create', ['job_id' => $jobId]) ],
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
                <th>name</th>
                <th>job title</th>
                <th>company</th>
                <th>phone</th>
                <th>email</th>
                <th>sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>job title</th>
                <th>company</th>
                <th>phone</th>
                <th>email</th>
                <th>sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($jobCoworkers as $jobCoworker)

                <tr>
                    <td>
                        {{ $jobCoworker->name }}
                    </td>
                    <td>
                        {{ $jobCoworker->job_title }}
                    </td>
                    <td>
                        @if($jobCoworker->job)
                            {{ $jobCoworker->job['company'] }}
                        @endif
                    </td>
                    <td class="text-nowrap">
                        {{ !empty($jobCoworker->personal_phone) ? $jobCoworker->personal_phone : $jobCoworker->work_phone }}
                    </td>
                    <td class="text-nowrap">
                        {{ !empty($jobCoworker->personal_email) ? $jobCoworker->personal_email : $jobCoworker->work_email }}
                    </td>
                    <td>
                        {{ $jobCoworker->sequence }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->public ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobCoworker->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.job-coworker.destroy', $jobCoworker->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.job-coworker.show', $jobCoworker->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.job-coworker.edit', $jobCoworker->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($jobCoworker->link))
                                <a title="{{ $jobCoworker->link_name }}" class="button is-small px-1 py-0" href="{{ $jobCoworker->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="{{ $jobCoworker->link_name }}" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">There are no job coworkers.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobCoworkers->links('vendor.pagination.bulma') !!}

    </div>

@endsection
