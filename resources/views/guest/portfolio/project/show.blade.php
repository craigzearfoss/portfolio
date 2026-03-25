@php
    $title    = $pageTitle ?? filteredPageTitle('Project: ' . $project->name, $owner->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
            [ 'name' => 'Projects',   'href' => route('guest.portfolio.project.index', $owner) ],
            [ 'name' => $project->name ],
          ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.project.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $project->disclaimer ])

    <div class="show-container card p-4">

        <table>
            <tbody>

            @if(!empty($project->name))
                <tr>
                    <th>name:</th>
                    <td>{{ $project->name }}</td>
                </tr>
           @endif

            @if(!empty($project->summary))
                <tr>
                    <th>summary:</th>
                    <td>{!! $project->summary !!}</td>
                </tr>
            @endif

            @if(!empty($project->year))
                <tr>
                    <th>year:</th>
                    <td>{{ $project->year }}</td>
                </tr>
            @endif

            @if(!empty($project->language))
                <tr>
                    <th>language:</th>
                    <td>{{ $project->language }}</td>
                </tr>
            @endif

            @if(!empty($project->language_version))
                <tr>
                    <th>language version:</th>
                    <td>{{ $project->language_version }}</td>
                </tr>
            @endif

            @if(!empty($project->repository_url))
                <tr>
                    <th>repository:</th>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $project->repository_url,
                            'href'   => $project->repository_url,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($project->link))
                <tr>
                    <th>{{ !empty($project->link_name) ? $project->link_name : 'link' }}:</th>
                    <td>
                        @include('guest.components.link', [
                            'href'   => $project->link,
                            'target' => '_blank'
                        ])
                    </td>
                </tr>
            @endif

            @if(!empty($project->description))
                <tr>
                    <th>description:</th>
                    <td>{!! $project->description !!}</td>
                </tr>
            @endif

            @if(!empty($project->image))
                <tr>
                    <td colspan="2">
                        @include('guest.components.image-credited', [
                            'name'         => 'image',
                            'src'          => $project->image,
                            'alt'          => $project->name . (!empty($project->artist) ? ', ' . $project->artist : ''),
                            'width'        => '300px',
                            'download'     => true,
                            'external'     => true,
                            'filename'     => generateDownloadFilename($project),
                            'image_credit' => $project->image_credit,
                            'image_source' => $project->image_source,
                        ])
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>

@endsection
