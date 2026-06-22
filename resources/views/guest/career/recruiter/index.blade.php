@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Career\Recruiter';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? 'Staffing & Recruiting Firms';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index') ],
            [ 'name' => 'Staffing & Recruiting Firms' ],
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

@include('guest.components.search-panel.career-recruiter')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="width: auto;">

            <p><i>{{ number_format($recruiters->total()) }} {{ ($recruiters->total() === 1) ? 'record' : 'records' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $recruiters->links('vendor.pagination.bulma') !!}
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
                            'name'  => 'founded',
                            'sort'  => 'founded|desc',
                        ])
                    </th>
                    <th>location</th>
                    <th style="display: none;">public</th>
                    <th style="display: none;">disabled</th>
                    <th class="has-text-centered" style="white-space: nowrap;">job openings</th>
                </tr>
                </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($recruiters as $recruiter)

                    <tr data-id="{{ $recruiter->id }}" {!! $recruiter->is_disabled ? 'class="disabled-text"' : '' !!}>
                        <td data-field="name" style="white-space: nowrap;">
                            <span {!! $recruiter->primary ? 'class="has-text-weight-bold"' : '' !!}>
                                @include('admin.components.link', [
                                    'name'  => $recruiter->name,
                                    'href'  => route('guest.career.recruiter.show', $recruiter->slug),
                                    'class' => $recruiter->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </span>
                            @include('admin.components.link-icon', [
                                'title'      => 'add to favorites',
                                'icon'       => 'fa-heart',
                                'border'     => false,
                                'target'     => '_blank',
                                'class'      => 'add-to-favorites',
                                'attributes' => [ 'data-resource' => 'career.recruiter', 'data-id' => $recruiter->id ]
                            ])
                            @if (!empty($recruiter->link))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $recruiter->link,
                                    'icon'   => 'fa-external-link',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                        <td data-field="recruiter_industry_name" style="white-space: nowrap;">
                            {{ $recruiter->recruiterIndustry->name ?? '' }}
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap;">
                            {{ implode(', ', $recruiter->coverageAreas ?? []) }}
                        </td>
                        <td data-field="founded" class="has-text-centered" style="white-space: nowrap;">
                            {{ $recruiter->founded }}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {!!
                                !empty($recruiter->country->iso_alpha3) && ($recruiter->country->iso_alpha3 != 'USA')
                                     ? formatLocation([
                                         'city'    => htmlspecialchars($recruiter->city),
                                          'state'   => $recruiter->state->code ?? '',
                                          'country' => $recruiter->country->iso_alpha3
                                      ])
                                   : formatLocation([
                                          'city'    => htmlspecialchars($recruiter->city),
                                          'state'   => $recruiter->state->code ?? '',
                                  ])
                            !!}
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->is_disabled ])
                        </td>
                        <td class="has-text-centered">
                            @if (!empty($recruiter->jobs_url))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $recruiter->jobs_url,
                                    'icon'   => 'fa-briefcase',
                                    'border' => false,
                                    'target' => '_blank'
                                ])
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No staffing firms found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $recruiters->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
