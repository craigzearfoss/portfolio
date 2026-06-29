@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $jobBoard         = $jobBoard ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? $jobBoard->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Job Boards', 'href' => route('guest.career.job-board.index') ],
        [ 'name' => $jobBoard->name ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.career.job-board.index', $owner)])->render(),
    ];

    $regions = [];
    if ($jobBoard->local) $regions[] = 'local';
    if ($jobBoard->regional) $regions[] = 'regional';
    if ($jobBoard->national) $regions[] = 'national';
    if ($jobBoard->international) $regions[] = 'international';
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $jobBoard->disclaimer ])

    <div class="show-container p-4">

        <table class="table guest-resource-table is-striped is-bordered" style="width: 40rem;">
            <tbody>

            <?php /*
            @if (!empty($jobBoard->name))
                <tr>
                    <th>name</th>
                    <td>{{ $jobBoard->name }}</td>
                </tr>
            @endif
            */ ?>

            @if (!empty($jobBoard->summary))
                <tr>
                    <th>summary</th>
                    <td>{!! $jobBoard->summary !!}</td>
                </tr>
           @endif

            @if (!empty($jobBoard->recruiter_industry_id))
                <tr>
                    <th>industry</th>
                    <td>{{ $jobBoard->recruiterIndustry['name'] ?? '' }}</td>
                </tr>
            @endif

            @if (!empty($jobBoard->specialties))
                <tr>
                    <th>specialties</th>
                    <td>{{ str_replace('|', ', ', $jobBoard->specialties) }}</td>
                </tr>
            @endif

            @if (!empty($jobBoardTypes))
                <tr>
                    <th>type(s)</th>
                    <td>{{ implode(', ', $jobBoardTypes) }}</td>
                </tr>
            @endif

            @if (!empty($regions))
                <tr>
                    <th>coverage area</th>
                    <td>{{ implode(', ', $regions) }}</td>
                </tr>
            @endif

            @if (!empty($jobBoard->founded))
                <tr>
                    <th>founded</th>
                    <td>{{ $jobBoard->founded }}</td>
                </tr>
            @endif

            @if (!empty($jobBoard->link))
                <tr>
                    <th>website</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $jobBoard->link,
                            'href'   => $jobBoard->link,
                            'target' => '_blank'
                        ])
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $jobBoard->link,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                            'style'  => [ 'margin-top:-4px' ]
                        ])
                    </td>
                </tr>
           @endif

            @if (!empty($jobBoard->linkedin_url))
                <tr>
                    <th>LinkedIn profile</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $jobBoard->linkedin_url,
                            'href'   => $jobBoard->linkedin_url,
                            'target' => '_blank'
                        ])
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $jobBoard->linkedin_url,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                            'style'  => [ 'margin-top: -4px' ]
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($jobBoard->jobs_url))
                <tr>
                    <th>job openings</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $jobBoard->jobs_url,
                            'href'   => $jobBoard->jobs_url,
                            'target' => '_blank'
                        ])
                        @include('guest.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $jobBoard->jobs_url,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($jobBoard->street) || !empty($jobBoard->street2) || !empty($jobBoard->city) || !empty($jobBoard->zip)
                || !empty($jobBoard->state->code ?? '') || !empty($jobBoard->country->iso_alpha3 ?? ''))

                <tr>
                    <th>location</th>
                    <td>
                        {!!
                            formatLocation([
                               'street'          => $jobBoard->street,
                               'street2'         => $jobBoard->street2,
                               'city'            => $jobBoard->city,
                               'state'           => $jobBoard->state->code ?? '',
                               'zip'             => $jobBoard->zip,
                               'country'         => $jobBoard->country->iso_alpha3 ?? '',
                               'streetSeparator' => '<br>',
                            ])
                        !!}
                    </td>
                </tr>

            @endif

            @if (!empty($jobBoard->phone) || !empty($jobBoard->alt_phone) || !empty($jobBoard->email) || !empty($jobBoard->alt_email))

                @if (!empty($jobBoard->phone))
                    <tr>
                        <th>{{ !empty($jobBoard->phone_label) ? $jobBoard->phone_label: 'phone' }}</th>
                        <td>{{ $jobBoard->phone }}</td>
                    </tr>
                @endif

                @if (!empty($jobBoard->alt_phone))
                    <tr>
                        <th>{{ !empty($jobBoard->alt_phone_label) ? $jobBoard->alt_phone_label: 'alt phone' }}</th>
                        <td>{{ $jobBoard->alt_phone }}</td>
                    </tr>
                @endif

                @if (!empty($jobBoard->email))
                    <tr>
                        <th>{{ !empty($jobBoard->email_label) ? $jobBoard->email_label: 'email' }}</th>
                        <td>{{ $jobBoard->email }}</td>
                    </tr>
                @endif

                @if (!empty($jobBoard->alt_email))
                    <tr>
                        <th>{{ !empty($jobBoard->alt_email_label) ? $jobBoard->alt_email_label: 'alt email' }}</th>
                        <td>{{ $jobBoard->alt_email }}</td>
                    </tr>
                @endif

            @endif

        </table>

    </div>

@endsection
