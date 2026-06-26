@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $photo = $photo ?? null;

    $title    = 'Edit ' . getResourcePageTitle($photo);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                           'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                        'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                         'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Photography',                       'href' => route('admin.portfolio.photography.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($photo, false), 'href' => route('admin.portfolio.photography.show', $photo) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.photography.index') ])->render(),
    ];
@endphp
@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.photography.update', array_merge([$photo], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.photography.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $photo->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $photo->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $photo->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $photo->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $photo->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'artist',
                    'value'     => old('artist') ?? $photo->artist,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $photo->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $photo->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-summary' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'photo_year',
                    'label'     => 'year',
                    'value'     => old('photo_year') ?? $photo->photo_year,
                    'min'       => -2000,
                    'max'       => date("Y"),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'credit',
                    'value'     => old('credit') ?? $photo->credit,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $photo->link,
                    'name'    => old('link_name') ?? $photo->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $photo->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $photo->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $photo,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $photo->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $photo->is_public,
                    'is_readonly' => old('is_readonly') ?? $photo->is_readonly,
                    'is_root'     => old('is_root')     ?? $photo->is_root,
                    'is_disabled' => old('is_disabled') ?? $photo->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $photo->is_demo,
                    'sequence'    => old('sequence')    ?? $photo->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.photography.index')
        ])

    </form>

@endsection
