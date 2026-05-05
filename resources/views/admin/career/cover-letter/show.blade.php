@php

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $coverLetter   = $coverLetter ?? null;

    $title = getResourcePageTitle($coverLetter);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                       'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',            'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',    'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',        'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',  'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Cover Letters', 'href' => route('admin.career.cover-letter.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($coverLetter, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($coverLetter, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.cover-letter.edit', $coverLetter) ])->render();
    }
    if (canCreate($coverLetter, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Cover Letter',
                                                                  'href' => route('admin.career.cover-letter.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.cover-letter.index') ])->render();

    $fileExtension = !empty($coverLetter->filepath)
        ? Illuminate\Support\Facades\File::extension($coverLetter->filepath)
        : '';
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
                            <li id="initial-selected-tab"  class="is-active" data-target="cover-letter">
                                <a>Cover Letter</a>
                            </li>
                            <li data-target="details">
                                <a>Details</a>
                            </li>

                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="cover-letter">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'    => 'application',
                                    'value'   => view('admin.components.link', [
                                                     'name' => $coverLetter->name,
                                                     'href' => route('admin.career.application.show', $coverLetter->application),
                                                 ]),
                                ])

                                @if (!empty($coverLetter->content))

                                    <?php /*
                                    @include('admin.components.show-row', [
                                        'name'    => 'content',
                                        'value'   => $coverLetter->content,
                                    ])
                                    */ ?>

                                @endif

                                <div class="property-list columns">
                                    <div class="column is-2 label" style="min-width: 6rem;">
                                        <strong>file</strong>:
                                        @if (!empty($coverLetter->filepath))
                                            @include('admin.components.download-links', [
                                                'name'     => 'image',
                                                'href'     => imageUrl($coverLetter->filepath),
                                                'filename' => Str::slug(str_replace('CoverLetter: ', '', $title)). '.' . substr(strrchr($coverLetter->filepath, '.'), 1),
                                                'download' => true,
                                                'external' => !in_array($fileExtension, [ 'doc', 'docx' ]),
                                            ])
                                        @endif
                                    </div>
                                    <div class="column is-10 value">

                                        @if (config('app.upload_enabled'))
                                            @include('admin.components.button-upload-document', [
                                                'modalTitle'  => 'Replace ' . str_replace('CoverLetter: ', '', $title) . ' cover letter file',
                                                'label'       => empty($coverLetter->filepath) ? 'Upload' : 'Replace',
                                                'resource'    => $coverLetter,
                                                'column'      => 'filepath',
                                                'target_data' => 'resource-filepath',
                                            ])
                                        @endif

                                    </div>
                                </div>


                            @if (!empty($coverLetter->filepath))

                                    @if ($fileExtension == 'pdf')

                                        <iframe src="{{ '/' . trim(str_replace('\\', '/', $coverLetter->filepath), ' /') }}"
                                                style="width:100%; min-height:800px; border: 1px solid #ccc;"
                                        >
                                        </iframe>

                                    @elseif (in_array($fileExtension, ['doc', 'docx']))

                                        <iframe src="{{ route('view-document', ['file' => $coverLetter->filepath]) }}"
                                                style="width:100%; min-height:800px; border: 1px solid #ccc;"
                                        >
                                        </iframe>

                                    @else

                                        <iframe src="{{ '/' . str_replace(DIRECTORY_SEPARATOR, '\\', trim($coverLetter->filepath, ' /\\')) }}"
                                                style="width:100%; min-height:300px; border: 1px solid #ccc;"
                                        >
                                        </iframe>

                                    @endif

                                @endif

                            </div>

                        </div>

                        <div id="details">

                            <div class="show-container card p-4">

                                @include('admin.components.show-row', [
                                    'name'  => 'id',
                                    'value' => $coverLetter->id
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'id',
                                    'value' => $coverLetter->id,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'owner',
                                    'value' => $coverLetter->owner->username,
                                    'hide'  => !$isRootAdmin,
                                ])

                                @include('admin.components.show-row', [
                                    'name'    => 'application',
                                    'value'   => view('admin.components.link', [
                                                     'name' => $coverLetter->name,
                                                     'href' => route('admin.career.application.show', $coverLetter->application),
                                                 ]),
                                    'message' => $message ?? '',
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'name',
                                    'value' => $coverLetter->name
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'  => 'date',
                                    'value' => longDate($coverLetter->cover_letter_date)
                                ])

                                <div class="property-list columns">
                                    <div class="column is-2 label">
                                        <strong>file</strong>:
                                    </div>
                                    <div class="column is-10 value">

                                        @if (!empty($coverLetter->filepath))
                                            {{ substr(strrchr($coverLetter->filepath, DIRECTORY_SEPARATOR), 1) }}
                                            @include('admin.components.download-links', [
                                                'name'     => 'image',
                                                'href'     => imageUrl($coverLetter->filepath),
                                                'filename' => Str::slug(str_replace('CoverLetter: ', '', getResourcePageTitle($coverLetter)))
                                                                  . '.' . substr(strrchr($coverLetter->filepath, '.'), 1),
                                                'download' => true,
                                                'external' => !in_array($fileExtension, [ 'doc', 'docx' ]),
                                            ])
                                        @else
                                            <i>none (Add via the Cover Letter tab.)</i>
                                        @endif

                                    </div>
                            </div>

                                <?php /*
                                @include('admin.components.show-row', [
                                    'name'  => 'content',
                                    'value' => $coverLetter->content
                                ])
                                */ ?>

                                @include('admin.components.show-row', [
                                    'name'  => 'notes',
                                    'value' => $coverLetter->notes
                                ])

                                @include('admin.components.show-row-link', [
                                    'name'   => 'link',
                                    'href'   => $coverLetter->link,
                                    'target' => '_blank'
                                ])

                                @include('admin.components.show-row', [
                                    'name'   => 'link name',
                                    'label'  => 'link_name',
                                    'value'  => $coverLetter->link_name,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'description',
                                    'value' => $coverLetter->description
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'disclaimer',
                                    'value' => view('admin.components.disclaimer', [
                                                    'value' => $coverLetter->disclaimer
                                               ])
                                ])

                                @include('admin.components.show-row-images', [
                                    'resource' => $coverLetter,
                                    'download' => true,
                                    'external' => true,
                                ])

                                @include('admin.components.show-row-visibility', [
                                    'resource' => $coverLetter,
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'created at',
                                    'value' => longDateTime($coverLetter->created_at)
                                ])

                                @include('admin.components.show-row', [
                                    'name'  => 'updated at',
                                    'value' => longDateTime($coverLetter->updated_at)
                                ])

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>

@endsection
