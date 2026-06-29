@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $school            = $school ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('School: ' . $school->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
            [ 'name' => 'Home',    'href' => route('guest.index') ],
            [ 'name' => 'Schools', 'href' => route('guest.portfolio.school.index', $owner) ],
            [ 'name' => $school->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.school.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $school->disclaimer ])

    <div class="show-container p-4">

        <table class="table guest-resource-table is-striped is-bordered" style="width: 40rem;">
            <tbody>

            @if (!empty($school->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $school->name }}</td>
                </tr>
            @endif

            @if (!empty($school->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $school->summary !!}</td>
                </tr>
            @endif

            <tr>
                <th>details:</th>
                <td>{!! view('guest.components.partials.school-details', [ 'school' => $school ]) !!}</td>
            </tr>

            @if (!empty($school->former_names))
                <tr>
                    <th style="white-space: nowrap;">former names:</th>
                    <td>{!! str_replace(',', '<br>', $school->former_names) !!}</td>
                </tr>
            @endif

            @if (!empty($school->nickname))
                <tr>
                    <th>nickname:</th>
                    <td>{{ str_replace('|', ', ', $school->nickname) }}</td>
                </tr>
            @endif

            @if (!empty($school->mascot))
                <tr>
                    <th>mascot:</th>
                    <td>{{ str_replace('|', ', ', $school->mascot) }}</td>
                </tr>
            @endif

            @if (!empty($school->colors))
                <tr>
                    <th>colors:</th>
                    <td>{{ str_replace('|', ', ', $school->colors) }}</td>
                </tr>
            @endif

            <tr>
                <th>location:</th>
                <td>
                    {!!
                        formatLocation([
                           'street'          => $school->street,
                           'street2'         => $school->street2,
                           'city'            => $school->city,
                           'state'           => $school->state->code ?? '',
                           'zip'             => $school->zip,
                           'country'         => $school->country->iso_alpha3 ?? '',
                           'streetSeparator' => ', ',
                       ])
                    !!}
                </td>
            </tr>

            @if (!empty($school->link))
                <tr>
                    <th>website:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $school->link,
                            'href'   => $school->link,
                            'target' => '_blank'
                        ])
                        @if (!empty($school->link))
                            @include('guest.components.link-icon', [
                                'title'  => 'open link in new window',
                                'href'   => $school->link,
                                'icon'   => 'fa-external-link',
                                'border' => false,
                                'target' => '_blank',
                                'style'  => [ 'margin-top: -4px' ]
                            ])
                        @endif
                    </td>
                </tr>
            @endif

            @if (!empty($school->wikipedia))
                <tr>
                    <th>wikipedia:</th>
                    <td>
                        {{ $school->wikipedia }}
                        @if (!empty($school->wikipedia))
                            @include('guest.components.link-icon', [
                                'title'  => 'open link in new window',
                                'href'   => $school->wikipedia,
                                'icon'   => 'fa-external-link',
                                'border' => false,
                                'target' => '_blank',
                                'style'  => [ 'margin-top: -4px' ]
                            ])
                        @endif
                    </td>
                </tr>
            @endif

            @if (!empty($school->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $school->description !!}</td>
                </tr>
            @endif

            @if (!empty($school->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $school->image,
                            'alt'          => $school->name . (!empty($school->artist) ? ', ' . $school->artist : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($school),
                            'image_credit' => $school->image_credit,
                            'image_source' => $school->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
