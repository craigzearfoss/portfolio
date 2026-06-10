@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Career\Recruiter';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = 'Recruiters & Staffing Firms';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index') ],
            [ 'name' => 'Recruiters & Staffing Firms' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 60rem;">

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
                        <th>name</th>
                        <th style="white-space: nowrap;">coverage area</th>
                        <th>location</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($recruiters as $recruiter)

                    <tr>
                        <td data-field="name" style="white-space: nowrap;">
                            <?php /*
                            @include('admin.components.link', [
                                'name' => $recruiter->name . (!empty($recruiter->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href' => route('guest.career.recruiter.show', $recruiter)
                            ])
                            */ ?>
                            {!! $recruiter->name . (!empty($recruiter->featured) ? '<span class="featured-splat">*</span>' : '') !!}
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap;">
                            {{ implode(', ', $recruiter->coverageAreas ?? []) }}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {{
                                formatLocation([
                                    'city'    => htmlspecialchars($recruiter->city),
                                    'state'   => $recruiter->state->code ?? '',
                                ])
                            }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">No job boards found.</td>
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
