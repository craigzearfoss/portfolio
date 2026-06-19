@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner              = $owner ?? null;
    $recruiter          = $recruiter ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title = $pageTitle ?? htmlspecialchars($recruiter->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                         'href' => route('guest.index') ],
        [ 'name' => 'Staffing & Recruiting Firms',  'href' => route('guest.career.recruiter.index') ],
        [ 'name' => htmlspecialchars($recruiter->name) ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.career.recruiter.index', $owner)])->render(),
    ];

    $regions = [];
    if ($recruiter->local) $regions[] = 'local';
    if ($recruiter->regional) $regions[] = 'regional';
    if ($recruiter->national) $regions[] = 'national';
    if ($recruiter->international) $regions[] = 'international';
    $region = implode(', ', $regions);
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($recruiter->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            <?php /*
            @if (!empty($recruiter->name))
                <tr>
                    <th>name</th>
                    <td>{{ htmlspecialchars($recruiter->name) }}</td>
                </tr>
            @endif
            */ ?>

            @if (!empty($recruiter->summary))
                <tr>
                    <th>summary</th>
                    <td>{{ htmlspecialchars($recruiter->summary) }}</td>
                </tr>
           @endif

            @if (!empty($recruiter->founded))
                <tr>
                    <th>founded</th>
                    <td>{{ $recruiter->founded }}</td>
                </tr>
            @endif

            @if (!empty($recruiter->recruiter_industry_id))
                <tr>
                    <th>industry</th>
                    <td>{{ $recruiter->recruiterIndustry['name'] ?? '' }}</td>
                </tr>
            @endif

            @if (!empty($recruiter->specialties))
                <tr>
                    <th>specialties</th>
                    <td>{{ str_replace('|', ', ', $recruiter->specialties) }}</td>
                </tr>
            @endif

            <tr>
                <th>coverage area</th>
                <td>{{ $region }}</td>
            </tr>

            @if (!empty($recruiter->link))
                <tr>
                    <th>website</th>
                    <td>
                        {!! $recruiter->link !!}
                        <div class="mb-2" style="display: inline-block; line-height: 2;">
                            @include('admin.components.link-icon', [
                                'title'  => 'open link in new window',
                                'href'   => $recruiter->link,
                                'icon'   => 'fa-external-link',
                                'border' => false,
                                'target' => '_blank',
                            ])
                        </div>
                    </td>
                </tr>
           @endif

            @if (!empty($recruiter->linkedin_url))
                <tr>
                    <th>LinkedIn profile</th>
                    <td>
                        {!! $recruiter->linkedin_url !!}
                        <div class="mb-2" style="display: inline-block; line-height: 2;">
                            @include('admin.components.link-icon', [
                                'title'  => 'open link in new window',
                                'href'   => $recruiter->linkedin_url,
                                'icon'   => 'fa-external-link',
                                'border' => false,
                                'target' => '_blank',
                            ])
                        </div>
                    </td>
                </tr>
            @endif

            @if (!empty($recruiter->jobs_url))
                <tr>
                    <th>job openings</th>
                    <td>
                        {!! $recruiter->jobs_url !!}
                        <div class="mb-2" style="display: inline-block; line-height: 2;">
                        @include('admin.components.link-icon', [
                            'title'  => 'open link in new window',
                            'href'   => $recruiter->jobs_url,
                            'icon'   => 'fa-external-link',
                            'border' => false,
                            'target' => '_blank',
                        ])
                    </td>
                </tr>
            @endif

            <tr>
                <th>location</th>
                <td>
                    {!!
                        formatLocation([
                           'street'          => htmlspecialchars($recruiter->street),
                           'street2'         => htmlspecialchars($recruiter->street2),
                           'city'            => htmlspecialchars($recruiter->city),
                           'state'           => $recruiter->state->code ?? '',
                           'zip'             => htmlspecialchars($recruiter->zip),
                           'country'         => $recruiter->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                        ])
                    !!}
                </td>
            </tr>

            @if (!empty($recruiter->phone))
                <tr>
                    <th>{{ !empty($recruiter->phone_label) ? $recruiter->phone_label: 'phone' }}</th>
                    <td>{{ $recruiter->phone }}</td>
                </tr>
            @endif

            @if (!empty($recruiter->alt_phone))
                <tr>
                    <th>{{ !empty($recruiter->alt_phone_label) ? $recruiter->alt_phone_label: 'alt phone' }}</th>
                    <td>{{ $recruiter->alt_phone }}</td>
                </tr>
            @endif

            @if (!empty($recruiter->email))
                <tr>
                    <th>{{ !empty($recruiter->email_label) ? $recruiter->email_label: 'email' }}</th>
                    <td>{{ $recruiter->email }}</td>
                </tr>
            @endif

            @if (!empty($recruiter->alt_email))
                <tr>
                    <th>{{ !empty($recruiter->alt_email_label) ? $recruiter->alt_email_label: 'alt email' }}</th>
                    <td>{{ $recruiter->alt_email }}</td>
                </tr>
            @endif

        </table>

    </div>

@endsection
