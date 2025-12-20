@extends('admin.layouts.default', [
    'title'         => 'Jobs',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Jobs' ]
    ],
    'buttons'       => [
        canCreate('job')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Job', 'href' => route('admin.portfolio.job.create') ]]
            : [],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    @if(!empty($resource->settings))

        <div class="card p-4" style="width: auto;">

            <div>
                Settings
            </div>
            <div>
            <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                <thead>
                <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>value</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($resource->settings as $setting)
                        <td>
                            {{ $setting->name }}
                        </td>
                        <td>
                            {{ $setting->type->name ?? '' }}
                        </td>
                        <td>
                            {{ $setting->value }}
                        </td>
                    @endforeach
                </tbody>
            </table>
            </div>

        </div>

    @endif

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>logo</th>
                <th>role</th>
                <th class="has-text-centered">featured</th>
                <th>start date</th>
                <th>end date</th>
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
                <ht>logo</th>
                <th>role</th>
                <th class="has-text-centered">featured</th>
                <th>start date</th>
                <th>end date</th>
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
                        <td data-field="owner.username">
                            {{ $job->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="company">
                        {{ $job->company }}
                    </td>
                    <td data-field="logo_small">
                        @include('admin.components.image', [
                            'src'   => $job->logo_small,
                            'alt'   => $job->name,
                            'width' => '48px',
                        ])
                    </td>
                    <td data-field="role">
                        {{ $job->role }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->featured ])
                    </td>
                    <td data-field="start_month|start_year">
                        @if(!empty($job->start_month)){{ date('F', mktime(0, 0, 0, $job->start_month, 10)) }} @endif
                        {{ $job->start_year }}
                    </td>
                    <td data-field="end_month|end_year">
                        @if(!empty($job->end_month)){{ date('F', mktime(0, 0, 0, $job->end_month, 10)) }} @endif
                        {{ $job->end_year }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.job.destroy', $job->id) }}" method="POST">

                            @if(canRead($job))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.job.show', $job->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($job))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.job.edit', $job) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif


                            @if (!empty($job->link))
                                <a title="{{ !empty($job->link_name) ? $job->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $job->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($job))
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There are no jobs.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobs->links('vendor.pagination.bulma') !!}

    </div>

@endsection
