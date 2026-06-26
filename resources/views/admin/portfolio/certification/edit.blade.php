@php
    use App\Models\Portfolio\CertificationType;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $certification = $certification ?? null;

    $title    = 'Edit ' . getResourcePageTitle($certification);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                           'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                                 'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',                            'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => getResourcePageTitle($certification, false), 'href' => route('admin.portfolio.certification.show', $certification) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.certification.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.certification.update', array_merge([$certification], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.certification.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $certification->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $certification->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $certification->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'abbreviation',
                    'label'     => 'abbreviation',
                    'value'     => old('abbreviation') ?? $certification->abbreviation,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'certification_type_id',
                    'label'    => 'certification type',
                    'value'    => old('certification_type_id') ?? $certification->certification_type_id,
                    'required' => true,
                    'list'     => new CertificationType()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'organization',
                    'label'     => 'organization',
                    'value'     => old('organization') ?? $certification->organization,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $certification->link,
                    'name'    => old('link_name') ?? $certification->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $certification->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.show-row-images', [
                    'resource' => $certification,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $certification->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $certification->is_public,
                    'is_readonly' => old('is_readonly') ?? $certification->is_readonly,
                    'is_root'     => old('is_root')     ?? $certification->root,
                    'is_disabled' => old('is_disabled') ?? $certification->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $certification->is_demo,
                    'sequence'    => old('sequence')    ?? $certification->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.certification.index')
        ])

    </form>

@endsection
