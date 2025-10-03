@extends('admin.layouts.default', [
    'title' => 'Applications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Create a New Application', 'href' => route('admin.career.application.create') ],
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
                <th class="has-text-centered">w2</th>
                <?php /*
                <th class="has-text-centered">relo</th>
                <th class="has-text-centered">ben</th>
                <th class="has-text-centered">vac</th>
                <th class="has-text-centered">health</th>
                */ ?>
                <th>source</th>
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
                <th class="has-text-centered">w2</th>
                <th class="has-text-centered">relo</th>
                <th class="has-text-centered">ben</th>
                <th class="has-text-centered">vac</th>
                <th class="has-text-centered">health</th>
                <th>source</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($applications as $application)

                <tr data-id="{{ $application->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $application->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="company.name" style="white-space: nowrap;">
                        @if(!empty($application->company))
                            @include('admin.components.link', [
                                'name' => $application->company['name'],
                                'href' => route('admin.career.company.show', $application->company['id'])
                            ])
                        @endif
                    </td>
                    <td data-field="role">
                        {{ $application->role }}
                    </td>
                    <td data-field="active" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->active ])
                    </td>
                    <td data-field="rating" class="has-text-centered ">
                        @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                    </td>
                    <td data-field="post_date" style="white-space: nowrap;">
                        {{ !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' }}
                    </td>
                    <td data-field="apply_date" style="white-space: nowrap;">
                        {{ !empty($application->apply_date) ? date('M j', strtotime($application->apply_date)) : '' }}
                    </td>
                    <td data-field="duration_id">
                        {{ $application->duration['name'] }}
                    </td>
                    <td data-field="compensation" style="white-space: nowrap;">
                        {!!
                            formatCompensation([
                                'min'   => $application->compensation_min ?? '',
                                'max'   => $application->compensation_max ?? '',
                                'unit'  => $application->compensation_unit['abbreviation'] ?? '',
                                'short' => true
                            ])
                        !!}
                    </td>
                    <td data-field="schedule_id">
                        {{ $application->schedule['name'] ?? '' }}
                    </td>
                    <td data-field="office_id">
                        {{ $application->office['name'] ?? '' }}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => $application->city ?? null,
                                'state'   => $application->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td data-field="w2" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                    </td>
                    <?php /*
                    <td data-field="relocation" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                    </td>
                    <td data-field="benefits" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                    </td>
                    <td data-field="vacation" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                    </td>
                    <td data-field="health" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->health ])
                    </td>
                    */ ?>
                    <td data-field="job_board_id">
                        {{ $application->job_board['name'] ?? '' }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.application.destroy', $application->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.show', $application->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.application.edit', $application->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($application->link))
                                <a title="{{ !empty($application->link_name) ? $application->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $application->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '15' : '14' }}">There are no applications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $applications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
