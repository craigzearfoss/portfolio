@php
    $buttons = [];
    if (canCreate('application', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Application', 'href' => route('admin.career.application.create') ];
    }
@endphp
@php
if (!empty($resume)) {
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
        [ 'name' => $resume->name,     'href' => route('admin.career.resume.show', $resume) ],
        [ 'name' => 'Applications' ]
    ];
} else {
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications' ]
    ];
}
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Applications' . (!empty($resume) ? ' for ' . $resume->name . ' resume' : ''),
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
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
                <?php /*
                <th>company</th>
                <th>role</th>
                */ ?>
                <th>active</th>
                <th>rating</th>
                <?php /*
                <th>posted</th>
                */ ?>
                <th>applied</th>
                <th>compensation</th>
                <?php /*
                <th>duration</th>
                */ ?>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">location</th>
                <th>location</th>
                    <?php /*
                <th class="has-text-centered">w2</th>
                <th class="has-text-centered">relo</th>
                <th class="has-text-centered">ben</th>
                <th class="has-text-centered">vac</th>
                <th class="has-text-centered">health</th>
                <th>source</th>
                */ ?>
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
                <th>company</th>
                <th>role</th>
                <th>active</th>
                <th>rating</th>
                <th>posted</th>
                <th>applied</th>
                <th>compensation</th>
                <th>duration</th>
                <th class="has-text-centered">employment<br>type</th>
                <th class="has-text-centered">location<br>type</th>
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
                            {{ $application->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{$application->name}}
                    </td>
                    <?php /*
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
                    */ ?>
                    <td data-field="active" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->active ])
                    </td>
                    <td data-field="rating" class="has-text-centered ">
                        @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                    </td>
                    <?php /*
                    <td data-field="post_date" style="white-space: nowrap;">
                        {{ !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' }}
                    </td>
                    */ ?>
                    <td data-field="apply_date" style="white-space: nowrap;">
                        {{ !empty($application->apply_date) ? date('M j', strtotime($application->apply_date)) : '' }}
                    </td>
                    <td data-field="compensation" style="white-space: nowrap;">
                        {!!
                            formatCompensation([
                                'min'   => $application->compensation_min ?? '',
                                'max'   => $application->compensation_max ?? '',
                                'unit'  => $application->compensationUnit['abbreviation'] ?? '',
                                'short' => true
                            ])
                        !!}
                    </td>
                    <?php /*
                    <td data-field="job_duration_id">
                        {{ $application->durationType['name'] }}
                    </td>
                    */ ?>
                    <td data-field="job_employment_type_id" class="has-text-centered" style="white-space: nowrap;">
                        {{ $application->employmentType['name'] ?? '' }}
                    </td>
                    <td data-field="job_location_type_id" class="has-text-centered">
                        {{ $application->locationType['name'] ?? '' }}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => $application->city ?? null,
                                'state'   => $application->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <?php /*
                    <td data-field="w2" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                    </td>
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
                    <td data-field="job_board_id">
                        {{ $application->jobBoard['name'] ?? '' }}
                    </td>
                    */ ?>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.application.destroy', $application->id) }}" method="POST">

                            @if(canRead($application))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.application.show', $application->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($application))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.application.edit', $application->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($application->link))
                                <a title="{{ !empty($application->link_name) ? $application->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $application->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($application))
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
                    <td colspan="{{ isRootAdmin() ? '14' : '13' }}">There are no applications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $applications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
