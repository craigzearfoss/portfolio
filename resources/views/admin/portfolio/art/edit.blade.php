@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $art         = $art ?? null;

    $title    = 'Edit ' . getResourcePageTitle($art);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                         'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                              'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                      'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                       'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Art',                             'href' => route('admin.portfolio.art.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($art, false), 'href' => route('admin.portfolio.art.show', $art) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.art.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.art.update', array_merge([$art], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.art.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $art->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $art->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of an art */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $art->owner_id
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $art->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'artist',
                    'value'     => old('artist') ?? $art->artist,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $art->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $art->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'style'     => [ 'max-width: 40rem !important' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'art_year',
                    'label'     => 'year',
                    'value'     => old('art_year') ?? $art->art_year,
                    'min'       => -2000,
                    'max'       => date("Y"),
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link' => old('link') ?? $art->link,
                    'name' => old('link_name') ?? $art->link_name,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $art->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'        => 'disclaimer',
                    'value'       => old('disclaimer') ?? $art->disclaimer,
                    'maxlength'   => 500,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $art,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $art->notes,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $art->is_public,
                    'is_readonly' => old('is_readonly') ?? $art->is_readonly,
                    'is_root'     => old('is_root')     ?? $art->root,
                    'is_disabled' => old('is_disabled') ?? $art->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $art->is_demo,
                    'sequence'    => old('sequence')    ?? $art->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.art.index')
        ])

    </form>

@endsection
