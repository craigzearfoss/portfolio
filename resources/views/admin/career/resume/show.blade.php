@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Resume: ' . $resume->name . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
        [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
        [ 'name' => 'Resumes',          'href' => route('admin.career.resume.index', ['application_id' => $application->id]) ]
    ];

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $resume, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.resume.edit', $resume)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'resume', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Resume', 'href' => route('admin.career.resume.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.resume.index')])->render();
@endphp

@extends('admin.layouts.default', [
    'title'         => $title,
    'subtitle'      => $subtitle,
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'menuService'   => $menuService,
    'admin'         => $admin,
    'user'          => $user,
    'owner'         => $owner,
])

@section('content')

    <section class="section p-0">
        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">
                        <ul>
                            <li class="is-active" data-target="resume">
                                <a>Resume</a>
                            </li>
                            <li data-target="details">
                                <a>Details</a>
                            </li>
                            <li data-target="applications">
                                <a>Applications</a>
                            </li>

                        </ul>

                        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
                        </div>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="resume">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $resume->name
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDate($resume->date)
                                ])

                                @if(!empty($resume->pdf_filepath))

                                    <iframe src="{{ str_replace('\\', '/', $resume->pdf_filepath) }}"
                                            style="width:100%; min-height:800px; border: 1px solid #ccc;">
                                    </iframe>

                                @elseif(!empty($resume->doc_filepath))

                                    <iframe src="{{ route('view-document', ['file' => $resume->doc_filepath]) }}"
                                            style="width:100%; min-height:800px; border: 1px solid #ccc;">
                                    </iframe>

                                @endif

                            </div>

                        </div>

                        <div id="details">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'id',
                                    'value' => $resume->id
                                ])

                                @if($admin->root)
                                    @include('admin.components.show-row', [
                                        'name'  => 'owner',
                                        'value' => $resume->owner->username
                                    ])
                                @endif

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $resume->name
                                ])

                                @include('admin.components.show-row-checkbox', [
                                    'name'    => 'primary',
                                    'checked' => $resume->primary
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDate($resume->date)
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'content',
                                    'value' => $resume->content
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => 'Word doc',
                                    'label'  => !empty($resume->doc_url) ? '<i class="fa-solid fa-download"></i>download' : '',
                                    'href'   => !empty($resume->doc_url) ? route('download-from-public', [ 'file' => $resume->doc_url, 'name' => $resume->slug ]) : null,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => 'PDF doc',
                                    'label'  => !empty($resume->pdf_url) ? '<i class="fa-solid fa-download"></i>download' : '',
                                    'href'   => !empty($resume->pdf_url) ? route('download-from-public', [ 'file' => $resume->pdf_url, 'name' => $resume->slug ]) : null,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $resume->notes
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'file type',
                                    'value' => $resume->file_type
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => !empty($resume->link_name) ? $resume->link_name : 'link',
                                    'href'   => $resume->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $resume->description
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'disclaimer',
                                    'value' => view('admin.components.disclaimer', [
                                                    'value' => $resume->disclaimer
                                               ])
                                ])

                                @include('admin.components.show-row-images', [
                                    'resource' => $resume,
                                    'download' => true,
                                    'external' => true,
                                ])

                                @include('admin.components.show-row-visibility', [
                                    'resource' => $resume,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'created at',
                                    'value' => longDateTime($resume->created_at)
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'updated at',
                                    'value' => longDateTime($resume->updated_at)
                                ])

                            </div>

                        </div>

                        <div id="applications">

                            <div class="show-container card p-4">

                                @include('admin.career.resume.application.panel', [
                                    'applications' => $resume->applications ?? [],
                                    'links' => []
                                ])

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
