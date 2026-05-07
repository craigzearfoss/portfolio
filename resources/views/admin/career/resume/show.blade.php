@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $resume      = $resume ?? null;

    $title    = getResourcePageTitle($resume);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Resumes',    'href' => route('admin.career.resume.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($resume, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($resume, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.resume.edit', $resume) ])->render();
    }
    if (canCreate($resume, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Resume',
                                                                  'href' => route('admin.career.resume.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.resume.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <section class="section p-0">
        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-2">
                        <ul>
                            <li id="initial-selected-tab" class="is-active" data-target="details">
                                <a>Details</a>
                            </li>
                            <li data-target="pdf-file">
                                <a>PDF file {!! empty($resume->pdf_filepath) ? ' <i>(none)</i>' : '' !!}</a>
                            </li>
                            <li data-target="word-file">
                                <a>Word file {!! empty($resume->doc_filepath) ? ' <i>(none)</i>' : '' !!}</a>
                            </li>
                            <li data-target="applications">
                                <a>Applications</a>
                            </li>

                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="details">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'id',
                                    'value' => $resume->id,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'owner',
                                    'value' => $resume->owner->username,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $resume->name
                                ])

                                @include('admin.components.show-row-checkmark', [
                                    'name'    => 'active',
                                    'checked' => $resume->active
                                ])

                                @include('admin.components.show-row-checkmark', [
                                    'name'    => 'primary',
                                    'checked' => $resume->primary
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDate($resume->resume_date)
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'content',
                                    'value' => $resume->content
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $resume->notes
                                ])

                                <?php /*
                                // we currently aren't using the file_type column
                                @include('admin.components.show-row', [
                                    'name'  => 'file type',
                                    'value' => $resume->file_type
                                ])
                                */ ?>

                                @include('admin.components.show-row-link', [
                                    'name'   => 'link',
                                    'href'   => $resume->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'   => 'link name',
                                    'label'  => 'link_name',
                                    'value'  => $resume->link_name,
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
                                    'upload'   => true,
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

                        <div id="pdf-file">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $resume->name
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDate($resume->resume_date)
                                ])

                                <div class="property-list columns">
                                    <div class="column is-2 label" style="min-width: 6rem;">
                                        <strong>PDF file</strong>:
                                        @if (!empty($resume->pdf_filepath))
                                            @include('admin.components.download-links', [
                                                'name'     => 'image',
                                                'href'     => imageUrl($resume->pdf_filepath),
                                                'filename' => Str::slug(str_replace('Resume: ', '', $title)). '.' . substr(strrchr($resume->pdf_filepath, '.'), 1),
                                                'download' => true,
                                                'external' => true,
                                            ])
                                        @endif
                                    </div>
                                    <div class="column is-10 value">

                                        @if (config('app.upload_enabled'))
                                            @include('admin.components.button-upload-document', [
                                                'modalTitle'  => (empty($resume->pdf_filepath) ? 'Upload ' : 'Replace ')
                                                    . str_replace('Resume: ', '', $title) . ' resume PDF file',
                                                'label'       => empty($resume->pdf_filepath) ? 'Upload' : 'Replace',
                                                'resource'    => $resume,
                                                'column'      => 'pdf_filepath',
                                                'target_data' => 'resource-pdf-filepath',
                                                'accept'      => 'pdf',
                                            ])
                                        @endif

                                    </div>
                                </div>

                                @if (!empty($resume->pdf_filepath))

                                    <iframe src="{{ '/' . trim(str_replace('\\', '/', $resume->pdf_filepath), ' /') }}"
                                            style="width:100%; min-height:800px; border: 1px solid #ccc;">
                                    </iframe>

                                @endif

                            </div>

                        </div>

                        <div id="word-file">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $resume->name
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDate($resume->resume_date)
                                ])

                                <div class="property-list columns">
                                    <div class="column is-2 label" style="min-width: 6rem;">
                                        <strong>MS Word file</strong>:
                                        @if (!empty($resume->doc_filepath))
                                            @include('admin.components.download-links', [
                                                'name'     => 'image',
                                                'href'     => imageUrl($resume->doc_filepath),
                                                'filename' => Str::slug(str_replace('Resume: ', '', $title)). '.' . substr(strrchr($resume->doc_filepath, '.'), 1),
                                                'download' => true,
                                                'external' => false,
                                            ])
                                        @endif
                                    </div>
                                    <div class="column is-10 value">

                                        @if (config('app.upload_enabled'))
                                            @include('admin.components.button-upload-document', [
                                                'modalTitle'  => (empty($resume->doc_filepath) ? 'Upload ' : 'Replace ')
                                                    . str_replace('Resume: ', '', $title) . ' resume MS Word file',
                                                'label'       => empty($resume->doc_filepath) ? 'Upload' : 'Replace',
                                                'resource'    => $resume,
                                                'column'      => 'doc_filepath',
                                                'target_data' => 'resource-doc_filepath',
                                                'accept'      => 'doc,docx',
                                            ])
                                        @endif

                                    </div>
                                </div>

                                @if (!empty($resume->doc_filepath))

                                    <iframe src="{{ route('view-document', ['file' => $resume->doc_filepath]) }}"
                                            style="width:100%; min-height:800px; border: 1px solid #ccc;">
                                    </iframe>

                                @endif

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
