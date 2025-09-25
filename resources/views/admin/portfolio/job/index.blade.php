@extends('admin.layouts.default', [
    'title' => 'Jobs',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Jobs' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job', 'url' => route('admin.portfolio.job.create') ],
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
                <th>role</th>
                <th>start date</th>
                <th>end date</th>
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
                <th>role</th>
                <th>start date</th>
                <th>end date</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($jobs as $job)

                <tr data-id="{{ $job->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($job->admin))
                                @include('admin.components.link', [
                                    'name' => $job->admin['username'],
                                    'url'  => route('admin.admin.show', $job->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="company">
                        {{ $job->company }}
                    </td>
                    <td data-field="role">
                        {{ $job->role }}
                    </td>
                    <td data-field="start_month|start_year" class="has-text-centered">
                        @if(!empty($job->start_month)){{ date('F', mktime(0, 0, 0, $job->start_month, 10)) }} @endif
                        {{ $job->start_year }}
                    </td>
                    <td data-field="end_month|end_year" class="has-text-centered">
                        @if(!empty($job->end_month)){{ date('F', mktime(0, 0, 0, $job->end_month, 10)) }} @endif
                        {{ $job->end_year }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->featured ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.job.destroy', $job->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job.show', $job->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.job.edit', $job->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>


                            @if (!empty($job->link))
                                <a title="{{ !empty($job->link_name) ? $job->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $job->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '9' : '8' }}">There are no jobs.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobs->links('vendor.pagination.bulma') !!}

    </div>

@endsection
