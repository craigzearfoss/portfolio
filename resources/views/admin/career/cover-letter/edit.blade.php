@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $coverLetter   = $coverLetter ?? null;

    $title    = 'Edit ' . getResourcePageTitle($coverLetter);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                          'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',               'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',       'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',           'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',     'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Cover Letters',    'href' => route('admin.career.cover-letter.index') ];
    $breadcrumbs[] = [ 'name' => $coverLetter->name, 'href' => route('admin.career.cover-letter.show', $coverLetter) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.cover-letter.index') ])->render(),
    ];

    // get the options for the application select list
    $applicationListOptions = new Application()->filteredListOptions($admin, $application->owner_id ?? null);
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($applicationListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no applications to attach a cover letter to.</p>
        </div>

    @else

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.cover-letter.update', array_merge([$coverLetter], request()->all())) }}"
                  class="admin-form"
                  method="POST"
            >
                @csrf
                @method('PUT')

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.cover-letter.index')
                ])

                <div class="floating-div-container">

                    <div class="floating-div card admin-form-card">

                        @if ($isRootAdmin)
                            @include('admin.components.favorites-box-form-input', [
                                'name'  => 'favorite_count',
                                'label' => 'favorites',
                                'value' => old('favorite_count') ?? $coverLetter->favorite_count,
                            ])
                        @endif

                        @include('admin.components.form-text-horizontal', [
                            'name'  => 'id',
                            'value' => $coverLetter->id
                        ])

                        @if ($isRootAdmin)
                            @include('admin.components.form-select-horizontal', [
                                'name'     => 'owner_id',
                                'label'    => 'owner',
                                'value'    => old('owner_id') ?? $coverLetter->owner_id,
                                'required' => true,
                                'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                'message'  => $message ?? '',
                                'class'    => [ 'select-owner' ]
                            ])
                        @else
                            @include('admin.components.form-hidden', [
                                'name'  => 'owner_id',
                                'value' => $coverLetter->owner_id
                            ])
                        @endif

                        <?php /* note you CANNOT change the application for a cover letter */ ?>
                        @include('admin.components.form-hidden', [
                            'name'  => 'application_id',
                            'value' => $coverLetter->application_id,
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'date',
                            'name'    => 'cover_letter_datetime',
                            'label'   => 'date',
                            'value'   => old('cover_letter_datetime') ?? $coverLetter->cover_letter_datetime,
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.show-row-document', [
                            'resource' => $coverLetter,
                            'column'   => 'filepath',
                            'label'    => 'file',
                            'filename' => $coverLetter->name,
                            'upload'   => false,
                            'download' => true,
                            'external' => true,
                            'editPage' => true,
                        ])

                        <?php /*
                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'content',
                            'id'      => 'inputEditor',
                            'value'   => old('content') ?? $coverLetter->content,
                            'message' => $message ?? '',
                        ])
                        */ ?>

                    </div>

                </div>
                <div class="floating-div-container">

                    <div class="floating-div card admin-form-card">


                    @include('admin.components.form-link-horizontal', [
                            'link'    => old('link') ?? $coverLetter->link,
                            'name'    => old('link_name') ?? $coverLetter->link_name,
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'description',
                            'id'      => 'inputEditor',
                            'value'   => old('description') ?? $coverLetter->description,
                            'message' => $message ?? '',
                            'class'   => [ 'textarea-description' ]
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'      => 'disclaimer',
                            'value'     => old('disclaimer') ?? $coverLetter->disclaimer,
                            'maxlength' => 500,
                            'cols'      => 30,
                            'rows'      => 3,
                            'message'   => $message ?? '',
                            'class'     => [ 'textarea-disclaimer' ],
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'notes',
                            'value'   => old('notes') ?? $coverLetter->notes,
                            'message' => $message ?? '',
                            'class'   => [ 'textarea-notes' ]
                        ])

                        @include('admin.components.form-visibility-horizontal', [
                            'is_public'   => old('is_public')   ?? $coverLetter->is_public,
                            'is_readonly' => old('is_readonly') ?? $coverLetter->is_readonly,
                            'is_root'     => old('is_root')     ?? $coverLetter->root,
                            'is_disabled' => old('is_disabled') ?? $coverLetter->is_disabled,
                            'is_demo'     => old('is_demo')     ?? $coverLetter->is_demo,
                            'sequence'    => old('sequence')    ?? $coverLetter->sequence,
                            'message'     => $message           ?? '',
                        ])

                    </div>

                </div>

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => referer('admin.career.cover-letter.index')
                ])

            </form>

        </div>

    @endif

@endsection
