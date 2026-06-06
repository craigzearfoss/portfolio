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
                                <a>MS Word file {!! empty($resume->doc_filepath) ? ' <i>(none)</i>' : '' !!}</a>
                            </li>
                            <li data-target="other-file">
                                <a>Other file {!! empty($resume->other_filepath) ? ' <i>(none)</i>' : '' !!}</a>
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

                                <?php /*
                                @include('admin.components.show-row', [
                                    'name'  => 'content',
                                    'value' => $resume->content
                                ])
                                */ ?>

                                @include('admin.components.show-row-link', [
                                    'link_name' => htmlspecialchars($resume->link_name ?? 'link'),
                                    'name'      => $resume->link,
                                    'href'      => $resume->link,
                                    'target'    => '_blank',
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $resume->description
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'disclaimer',
                                    'value' => view('admin.components.disclaimer', [
                                                    'value' => htmlspecialchars($resume->disclaimer)
                                               ])
                                ])

                                @include('admin.components.show-row-images', [
                                    'resource' => $resume,
                                    'upload'   => true,
                                    'download' => true,
                                    'external' => true,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => nl2br(htmlspecialchars($resume->notes))
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
                                    'name'  => 'date',
                                    'value' => longDateTime($resume->pdf_datetime)
                                ])

                                @include('admin.components.show-row-document', [
                                    'resource'        => $resume,
                                    'column'          => 'pdf_filepath',
                                    'datetime_column' => 'pdf_datetime',
                                    'label'           => 'file:',
                                    'filename'        => $resume->name,
                                    'accept'          => [ 'pdf' ],
                                    'upload'          => false,
                                    'download'        => true,
                                    'external'        => true,
                                ])

                            </div>

                        </div>

                        <div id="word-file">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDateTime($resume->doc_datetime)
                                ])

                                @include('admin.components.show-row-document', [
                                    'resource'        => $resume,
                                    'column'          => 'doc_filepath',
                                    'datetime_column' => 'doc_datetime',
                                    'label'           => 'file:',
                                    'filename'        => $resume->name,
                                    'accept'          => [ 'doc', 'docx'],
                                    'upload'          => false,
                                    'download'        => true,
                                    'external'        => true,
                                ])

                            </div>

                        </div>

                        <div id="other-file">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'date',
                                    'value' => longDateTime($resume->other_datetime)
                                ])

                                @include('admin.components.show-row-document', [
                                    'resource'        => $resume,
                                    'column'          => 'other_filepath',
                                    'datetime_column' => 'other_datetime',
                                    'label'           => 'file:',
                                    'filename'        => $resume->name,
                                    'accept'          => array_diff(config('app.upload_document_accept'), [ 'doc', 'docx', 'pdf' ]),
                                    'upload'          => true,
                                    'download'        => true,
                                    'external'        => true,
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
