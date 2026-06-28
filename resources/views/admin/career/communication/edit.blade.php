@php
    use App\Models\Career\Application;
    use App\Models\Career\CommunicationType;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $communication = $communication ?? null;

    $title    = 'Edit ' . getResourcePageTitle($communication);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                        'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                                'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                                    'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',                              'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Communications',                            'href' => route('admin.career.communication.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($communication, false), 'href' => route('admin.career.communication.show', $communication) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.communication.index') ])->render()
    ];

    // get the options for the application select list
    $applicationListOptions = new Application()->filteredListOptions($admin, $application->owner_id ?? null);
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($applicationListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no applications to attach a communication to.</p>
        </div>

    @else

        <form action="{{ route('admin.career.communication.update', array_merge([$communication], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => request()->query('referer') ?? referer('admin.career.communication.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $communication->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $communication->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? $communication->owner_id,
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-owner' ]
                        ])
                    @else
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $communication->owner_id
                        ])
                    @endif

                    <div class="field is-horizontal" style="line-height: 1.6">
                        <div class="field-label">
                            <label for="inputSubject" class="label">
                                application
                            </label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control ">
                                    @include('admin.components.link', [
                                        'name'   => $communication->application['name'],
                                        'href'   => route('admin.career.application.show', $communication->application),
                                        'target' => '_blank'
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'communication_type_id',
                        'label'    => 'type',
                        'value'    => old('communication_type_id') ?? $communication->communication_type_id,
                        'list'     => new CommunicationType()->listOptions([], 'id', 'name', true),
                        'required' => true,
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'subject',
                        'value'     => old('subject') ?? $communication->subject,
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ],
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'to',
                        'value'     => old('to') ?? $communication->to,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'class'     => [ 'input-name' ],
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'from',
                        'value'     => old('from') ?? $communication->from,
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                        'class'   => [ 'input-name' ],
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'    => 'datetime-local',
                        'name'    => 'communication_datetime',
                        'label'   => 'datetime',
                        'value'   => old('communication_datetime') ?? $communication->communication_datetime,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'body',
                        'id'      => 'inputEditor',
                        'value'   => old('body') ?? $communication->body,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-body' ],
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'name'      => 'link',
                        'link'      => old('link') ?? $communication->link,
                        'link_name' => old('link_name') ?? $communication->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $communication->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ],
                    ])

                </div>
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? $communication->disclaimer,
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 3,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-disclaimer' ],
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $communication->is_public,
                        'is_readonly' => old('is_readonly') ?? $communication->is_readonly,
                        'is_root'     => old('is_root')     ?? $communication->root,
                        'is_disabled' => old('is_disabled') ?? $communication->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $communication->is_demo,
                        'sequence'    => old('sequence')    ?? $communication->sequence,
                        'message'     => $message           ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $communication->notes,
                        'message' => $message ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.communication.index')
            ])

        </form>

    @endif

@endsection
