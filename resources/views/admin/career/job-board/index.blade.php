@php
    use App\Models\Career\JobBoard;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\JobBoard';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Job Boards';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobBoard::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Job Board',
                                                                  'href' => route('admin.career.job-board.create')
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-job-board')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.job-board.export', request()->except([ 'page' ])),
                'filename' => 'job_boards_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($jobBoards->total()) }} {{ ($jobBoards->total() === 1) ? 'job board' : 'job boards' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a primary job board. <span class="sample-color-box-light-gray"></span> indicates the job board is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="min-width: 60rem; max-width: 90rem; overflow-x: auto; overflow-y: hidden;">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'industry',
                                'sort'  => 'industry_name|asc',
                            ])
                        </th>
                        <th style="white-space: nowrap;">coverage area</th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'free',
                                'sort'  => 'free|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'premium',
                                'sort'  => 'premium|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'staffing',
                                'sort'  => 'staffing|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'freelance',
                                'sort'  => 'freelance|desc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'founded',
                                'sort'  => 'founded|desc',
                            ])
                        </th>
                        <th>location</th>
                        <th style="display: none;">public</th>
                        <th style="display: none;">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobBoards as $jobBoard)

                    <tr data-id="{{ $jobBoard->id }}" {!! $jobBoard->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id" style="width: 1rem;">
                                {{ $jobBoard->id }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap; width: 7rem;">
                            @include('admin.components.link', [
                                'name'            => $jobBoard->name . (!empty($jobBoard->primary) ? '<span class="primary-splat">*</span>' : ''),
                                'href'            => route('admin.career.job-board.show', $jobBoard),
                                'class'           => $jobBoard->is_disabled ? [ 'disabled-text' ] : [],
                                'style'           => [ 'display: inline-block', 'max-width: 20rem', 'overflow-x: hidden' ],
                                'title_attribute' => $jobBoard->name,
                            ])
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'career.job_board', 'data-id' => $jobBoard->id ]
                           ])
                        </td>
                        <td data-field="recruiter_industry_name" style="white-space: nowrap;">
                            {{ $jobBoard->recruiterIndustry->name ?? '' }}
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap; width: 6rem;">
                            {!! implode(', ', $jobBoard->coverageAreas ?? []) !!}
                        </td>
                        <td data-field="free" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->free ])
                        </td>
                        <td data-field="premium" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->premium ])
                        </td>
                        <td data-field="staffing" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->staffing ])
                        </td>
                        <td data-field="freelance" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->freelance ])
                        </td>
                        <td data-field="founded" class="has-text-centered">
                            {{ $jobBoard->founded }}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {!!
                                !empty($recruiter->country->iso_alpha3) && ($jobBoard->country->iso_alpha3 != 'USA')
                                    ? formatLocation([
                                          'city'    => htmlspecialchars($jobBoard->city),
                                          'state'   => $jobBoard->state->code ?? '',
                                          'country' => $jobBoard->country->iso_alpha3
                                      ])
                                   : formatLocation([
                                          'city'    => htmlspecialchars($jobBoard->city),
                                          'state'   => $jobBoard->state->code ?? '',
                                  ])
                            !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($jobBoard, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.job-board.show', $jobBoard),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($jobBoard, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.job-board.edit', $jobBoard),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($jobBoard->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($jobBoard->link_name) ? $jobBoard->link_name : 'link',
                                        'href'   => $jobBoard->link,
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

                                @if (canDelete($jobBoard, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.job-board.destroy', $jobBoard) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '13' : '12' }}">No job boards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
