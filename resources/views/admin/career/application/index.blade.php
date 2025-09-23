@extends('admin.layouts.default', [
    'title' => 'Applications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Applications' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Application', 'url' => route('admin.career.application.create') ],
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
                <th>active</th>
                <th>rating</th>
                <th>posted</th>
                <th>applied</th>
                <th>duration</th>
                <th>compensation</th>
                <th>schedule</th>
                <th>office</th>
                <th>location</th>
                <th>w2</th>
                <?php /*
                <th>relo</th>
                <th>ben</th>
                <th>vac</th>
                <th>health</th>
                */ ?>
                <th>source</th>
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
                <th>active</th>
                <th>rating</th>
                <th>posted</th>
                <th>applied</th>
                <th>duration</th>
                <th>compensation</th>
                <th>schedule</th>
                <th>office</th>
                <th>location</th>
                <th>w2</th>
                <th>relo</th>
                <th>ben</th>
                <th>vac</th>
                <th>health</th>
                <th>source</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($applications as $application)

                <tr>
                    @if(isRootAdmin())
                        <td>
                            {{ $application->admin['username'] ?? '' }}
                        </td>
                    @endif
                    <td>
                        {{ $application->company['name'] ?? '' }}
                    </td>
                    <td>
                        {{ $application->role }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->active ])
                    </td>
                    <td class="has-text-centered text-nowrap">
                        @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                    </td>
                        <td class="text-nowrap">
                            {{ !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' }}
                        </td>
                    <td class="text-nowrap">
                        {{ !empty($application->apply_date) ? date('M j', strtotime($application->apply_date)) : '' }}
                    </td>
                    <td>
                        {{ $application->duration['name'] }}
                    </td>
                    <td class="text-nowrap">
                        {!!
                            formatCompensation([
                                'min'   => $application->compensation_min ?? '',
                                'max'   => $application->compensation_max ?? '',
                                'unit'  => $application->compensation_unit['abbreviation'] ?? '',
                                'short' => true
                            ])
                        !!}
                    </td>
                    <td class="text-nowrap">
                        {{ $application->schedule['name'] ?? '' }}
                    </td>
                    <td class="text-nowrap">
                        {{ $application->office['name'] ?? '' }}
                    </td>
                    <td class="text-nowrap">
                        {!!
                            formatLocation([
                                'city'    => $application->city ?? null,
                                'state'   => $application->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                    </td>
                    <?php /*
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->health ])
                    </td>
                    */ ?>
                    <td>
                        {{ $application->job_board['name'] ?? '' }}
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.application.destroy', $application->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.show', $application->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.edit', $application->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($application->website))
                                <a title="website" class="button is-small px-1 py-0" href="{{ $application->website }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
                                </a>
                            @else
                                <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
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
                    <td colspan="{{ isRootAdmin() ? '15' : '14' }}">There are no applications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $applications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
