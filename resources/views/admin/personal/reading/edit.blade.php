@php

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $reading     = $reading ?? null;

    $title    = 'Edit ' . getResourcePageTitle($reading);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                  'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                          'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',                            'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Readings',                            'href' => route('admin.personal.reading.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($reading, false), 'href' => route('admin.personal.reading.show', $reading) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.reading.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.personal.reading.update', array_merge([$reading], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.reading.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $reading->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $reading->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $reading->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $reading->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'title',
                    'value'     => old('title') ?? $reading->title,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'author',
                    'value'     => old('author') ?? $reading->author,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $reading->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $reading->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-summary' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'publication_year',
                    'label'     => 'publication year',
                    'value'     => old('publication_year') ?? $reading->publication_year,
                    'required'  => true,
                    'min'       => -3000,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'fiction',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('fiction') ?? $reading->fiction,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'nonfiction',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('nonfiction') ?? $reading->nonfiction,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'paper',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('paper') ?? $reading->paper,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'audio',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('audio') ?? $reading->audio,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'wishlist',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('wishlist') ?? $reading->wishlist,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link'    => old('link') ?? $reading->link,
                        'name'    => old('link_name') ?? $reading->link_name,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $reading->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ]
                    ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $reading->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $reading,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $reading->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $reading->is_public,
                    'is_readonly' => old('is_readonly') ?? $reading->is_readonly,
                    'is_root'     => old('is_root')     ?? $reading->root,
                    'is_disabled' => old('is_disabled') ?? $reading->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $reading->is_demo,
                    'sequence'    => old('sequence')    ?? $reading->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.personal.reading.index')
        ])

    </form>

@endsection
