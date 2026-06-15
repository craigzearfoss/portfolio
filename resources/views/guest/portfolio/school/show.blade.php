@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $school            = $school ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('School: ' . htmlspecialchars($school->name));
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',                         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',                   'href' => route('guest.admin.index') ],
            [ 'name' => htmlspecialchars($owner->name), 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',                    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'School',                        'href' => route('guest.portfolio.school.index', $owner) ],
            [ 'name' => htmlspecialchars($school->name) ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.school.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => htmlspecialchars($school->disclaimer) ])

    <div class="show-container p-4">

        <table>
            <tbody>

            @if (!empty($school->name))
                <tr>
                    <th>name:</th>
                    <td>{!! htmlspecialchars($school->name) !!}</td>
                </tr>
            @endif

            @if (!empty($school->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! htmlspecialchars($school->summary) !!}</td>
                </tr>
            @endif

            <tr>
                <th>details:</th>
                <td>{!! view('admin.components.partials.school-details', [ 'school' => $school ]) !!}</td>
            </tr>

            @if (!empty($school->former_names))
                <tr>
                    <th style="white-space: nowrap;">former names:</th>
                    <td>{!! str_replace(',', '<br>', htmlspecialchars($school->former_names)) !!}</td>
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
                    <td>{!! str_replace('|', ', ', htmlspecialchars($school->colors)) !!}</td>
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
                    <th>link:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $school->link,
                            'href'   => $school->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($school->wikipedia))
                <tr>
                    <th>wikipedia:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $school->wikipedia,
                            'href'   => $school->wikipedia,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if (!empty($school->link))
                <tr>
                    <th>{{ !empty($school->link_name) ? $school->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($school->link_name) ? htmlspecialchars($school->link_name) : 'link',
                            'href'   => $school->link,
                            'target' => '_blank'
                        ])
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
                            'alt'          => htmlspecialchars($school->name) . (!empty($school->artist) ? ', ' . htmlspecialchars($school->artist) : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($school),
                            'image_credit' => htmlspecialchars($school->image_credit),
                            'image_source' => htmlspecialchars($school->image_source),
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
