@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $note        = $note ?? null;

    $title    = 'Edit ' . getResourcePageTitle($note);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                          'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                               'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                       'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                           'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',                     'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Notes',                            'href' => route('admin.career.note.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($note, false), 'href' => route('admin.career.note.show', $note) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.note.index') ])->render(),
    ];

    // get the options for the application select list
    $applicationListOptions = new Application()->filteredListOptions($admin, $application->owner_id ?? null);
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($applicationListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no applications to attach a note to.</p>
        </div>

    @else

        <form action="{{ route('admin.career.note.update', array_merge([$note], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.note.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $note->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $note->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? $note->owner_id,
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-owner' ]
                        ])
                    @else
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $note->owner_id
                        ])
                    @endif

                    <?php /* note you CANNOT change the application for a note */ ?>
                    @include('admin.components.form-hidden', [
                        'name'    => 'application_id',
                        'value'   => $note->application_id,
                    ])

                </div>

            </div>

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'subject',
                        'value'     => old('subject') ?? $note->subject,
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ]
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'body',
                        'id'      => 'inputEditor',
                        'value'   => old('body') ?? $note->body,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-body' ]
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link'      => old('link') ?? $note->link,
                        'link_name' => old('link_name') ?? $note->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $note->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ],
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'        => 'disclaimer',
                        'value'       => old('disclaimer') ?? $note->disclaimer,
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 3,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-disclaimer' ],
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $note->notes,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-notes' ],
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $note->is_public,
                        'is_readonly' => old('is_readonly') ?? $note->is_readonly,
                        'is_root'     => old('is_root')     ?? $note->is_root,
                        'is_disabled' => old('is_disabled') ?? $note->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $note->is_demo,
                        'sequence'    => old('sequence')    ?? $note->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.resume.index')
            ])

        </form>

    @endif

@endsection
