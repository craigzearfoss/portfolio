@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $certificate      = $certificate ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ?? filteredPageTitle('Certificate: ' . $certificate->name, $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',         'href' => route('guest.index') ],
            [ 'name' => 'Candidates',   'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name,   'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',    'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Certificates', 'href' => route('guest.portfolio.certificate.index', $owner) ],
            [ 'name' => $certificate->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.certificate.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $certificate->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($certificate->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $certificate->name }}</td>
                </tr>
           @endif

            @if(!empty($certificate->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $certificate->summary !!}</td>
                </tr>
            @endif

            @if(!empty($certificate->organization))
                <tr>
                    <th>organization:</th>
                    <td>{{ $certificate->organization }}</td>
                </tr>
            @endif

            @if(!empty($certificate->certificate_year))
                <tr>
                    <th>year:</th>
                    <td>{{ $certificate->certificate_year }}</td>
                </tr>
            @endif

            @if(!empty($certificate->academy))
                <tr>
                    <th>academy:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $certificate->academy['name'],
                            'href'   => $certificate->academy['link'],
                            'target' => '_blank',
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($certificate->certificate_url))
                <tr>
                    <th>certificate url:</th>
                    <td>
                        @include('guest.components.image', [
                            'name'     => 'certificate url',
                            'src'      => imageUrl($certificate->certificate_url),
                            'width'    => '300px',
                            'download' => true,
                            'external' => true,
                            'filename' => generateDownloadFilename($certificate)
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($certificate->link))
                <tr>
                    <th>{{ !empty($certificate->link_name) ? $certificate->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => !empty($certificate->link_name) ? $certificate->link_name : 'link',
                            'href'   => $certificate->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($certificate->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $certificate->description !!}</td>
                </tr>
            @endif

            @if(!empty($certificate->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $certificate->image,
                            'alt'          => $certificate->name,
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($certificate),
                            'image_credit' => $certificate->image_credit,
                            'image_source' => $certificate->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
