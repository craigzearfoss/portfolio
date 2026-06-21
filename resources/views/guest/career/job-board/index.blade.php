@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Career\JobBoard';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Job Boards';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index') ],
            [ 'name' => 'Job Boards' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <?php /*
    @if ($owner->is_demo)
        @if ($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($disclaimerMessage) ])
        @endif
    @endif
    */ ?>

    @include('guest.components.search-panel.career-job-board')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            <p><i>{{ number_format($jobBoards->total()) }} {{ ($jobBoards->total() === 1) ? 'record' : 'records' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
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
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($jobBoards as $jobBoard)

                    <tr data-id="{{ $jobBoard->id }}" {!! $jobBoard->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td style="white-space: nowrap;{{ $jobBoard->primary ? ' font-weight: 700;' : '' }}">
                            <span {!! $jobBoard->featured ? 'class="has-text-weight-bold"' : '' !!}>
                                {{ $jobBoard->name }}
                            </span>
                            @if (!empty($jobBoard->jobs_url) || !empty($jobBoard->link))
                                @include('guest.components.link-icon', [
                                    'title'  => 'job openings',
                                    'href'   => !empty($jobBoard->jobs_url) ? $jobBoard->jobs_url : $jobBoard->link,
                                    'icon'   => 'fa-briefcase',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                        <td data-field="recruiter_industry_name" style="white-space: nowrap;">
                            {{ $jobBoard->recruiterIndustry->name ?? '' }}
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap; width: 6rem;">
                            {!! implode(', ', $jobBoard->coverageAreas ?? []) !!}
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->free ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->premium ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->staffing ])
                        </td>
                        <td class="has-text-centered">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->freelance ])
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
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('guest.components.checkmark', [ 'checked' => $jobBoard->is_disabled ])
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No job boards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <p class="is-size-7"><i>* offers a premium or subscription-based service, ** offers staffing services, *** has a marketplace for freelance workers</i></p>

            @if (!empty($pagination_bottom))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
