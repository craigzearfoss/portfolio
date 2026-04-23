@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('certificates', $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Certificate' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.portfolio-certificate', [ 'owner_id' => $owner->id ?? null ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>academy</th>
                        <th class="hide-at-900">organization</th>
                        <th class="has-text-centered hide-at-600">year</th>
                        <th class="has-text-centered hide-at-1200">received</th>
                        <th class="has-text-centered hide-at-750">expiration</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>academy</th>
                        <th class="hide-at-900">organization</th>
                        <th class="has-text-centered hide-at-600">year</th>
                        <th class="has-text-centered hide-at-1200">received</th>
                        <th class="has-text-centered hide-at-750">expiration</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($certificates as $certificate)

                    <tr>
                        <td style="white-space: nowrap;">
                            @include('guest.components.link', [
                                'name'  => $certificate->name,
                                'href'  => route('guest.portfolio.certificate.show', [$certificate->owner->label, $certificate->slug]),
                                'class' => $certificate->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td style="white-space: nowrap;">
                            @if(!empty($certificate->academy->link))
                                {{ $certificate->academy->name }}
                            @else
                                @include('guest.components.link', [
                                    'name'   => $certificate->academy->name ?? '',
                                    'href'   => $certificate->academy->link ?? '',
                                    'target' => '_blank',
                                ])
                            @endif
                        </td>
                        <td class="hide-at-900" style="white-space: nowrap;">
                            {!! $certificate->organization !!}
                        </td>
                        <td class="has-text-centered hide-at-600">
                            {!! $certificate->certificate_year !!}
                        </td>
                        <td class="has-text-centered hide-at-1200">
                            {!! shortDate($certificate->received) !!}
                        </td>
                        <td class="has-text-centered hide-at-750">
                            {!! shortDate($certificate->expiration) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">No certificates found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
