@php
    use App\Models\Career\Application;

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

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.note.update', array_merge([$note], request()->all())) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.note.index')
                ])

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $note->favorite_count,
                    ])
                @endif

                <div class="floating-div-container">

                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                        @include('admin.components.form-text-horizontal', [
                            'name'  => 'id',
                            'value' => $note->id,
                            'hide'  => !$isRootAdmin,
                        ])

                        <?php /* note that you CANNOT change the owner of a note */ ?>
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $note->owner_id
                        ])

                        <?php /* note you CANNOT change the application for a note */ ?>
                        @include('admin.components.form-hidden', [
                            'name'    => 'application_id',
                            'value'   => $note->application_id,
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'name'      => 'subject',
                            'value'     => old('subject') ?? $note->subject,
                            'required'  => true,
                            'maxlength' => 255,
                            'message'   => $message ?? '',
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'body',
                            'id'      => 'inputEditor',
                            'value'   => old('body') ?? $note->body,
                            'message' => $message ?? '',
                        ])

                    </div>

                </div>
                <div class="floating-div-container">

                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="min-width: 60rem;">

                        @include('admin.components.form-link-horizontal', [
                            'link' => old('link') ?? $note->link,
                            'link_name' => old('link_name') ?? $note->link_name,
                            'message'   => $message ?? '',
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'description',
                            'id'      => 'inputEditor',
                            'value'   => old('description') ?? $note->description,
                            'message' => $message ?? '',
                        ])

                    </div>

                </div>
                <div class="floating-div-container">

                    <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="min-width: 60rem;">

                        @include('admin.components.form-input-horizontal', [
                            'name'        => 'disclaimer',
                            'value'       => old('disclaimer') ?? $note->disclaimer,
                            'maxlength'   => 500,
                            'message'     => $message ?? '',
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'notes',
                            'value'   => old('notes') ?? $note->notes,
                            'message' => $message ?? '',
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
                <div class="floating-div-container">

                    <div class="floating-div has-text-right m-2" style="width: 60rem;">

                        @include('admin.components.form-button-submit-horizontal', [
                            'label'      => 'Save',
                            'cancel_url' => referer('admin.career.resume.index')
                        ])

                    </div>

                </div>

            </form>

        </div>

    @endif

@endsection
