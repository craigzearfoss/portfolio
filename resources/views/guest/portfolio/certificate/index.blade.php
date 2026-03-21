@php
    $title    = $pageTitle ?? $owner->name . ' certificates';
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
                        <th>organization</th>
                        <th>year</th>
                        <th>received</th>
                        <th>expiration</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>academy</th>
                        <th>organization</th>
                        <th>year</th>
                        <th>received</th>
                        <th>expiration</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($certificates as $certificate)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $certificate->name,
                                'href'  => route('guest.portfolio.certificate.show', [$certificate->owner->label, $certificate->slug]),
                                'class' => $certificate->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
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
                        <td class="has-text-centered">
                            {!! $certificate->organization !!}
                        </td>
                        <td class="has-text-centered">
                            {!! $certificate->year !!}
                        </td>
                        <td class="has-text-centered">
                            {!! shortDate($certificate->received) !!}
                        </td>
                        <td class="has-text-centered">
                            {!! shortDate($certificate->expiration) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">There are no certificates.</td>
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
