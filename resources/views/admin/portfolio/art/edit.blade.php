@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $art         = $art ?? null;

    $title    = $pageTitle ?? 'Edit Art: ' . $art->name;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Art',        'href' => route('admin.portfolio.art.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $art->name,   'href' => route('admin.portfolio.art.show', [$art, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Art',        'href' => route('admin.portfolio.art.index') ];
        $breadcrumbs[] = [ 'name' => $art->name,   'href' => route('admin.portfolio.art.show', $art) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.art.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <?php /* @TODO: need to implement file uploads  */ ?>
    @if(config('app.upload_enabled'))
        @include('admin.components.overlay-image-upload', [
            'name'        => 'frmImageUpload',
            'action'      => route('admin.portfolio.image.upload', ['art', 'image']),
            'file'        => $art->image,
            'credit'      => $art->credit,
            'src'         => $art->source,
            'maxFileSize' => config('app.upload_max_file_size'),
            'accept'      => config('app.upload_image_accept'),
            'message'     => $message ?? '',
        ])
    @endif

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.art.update', array_merge([$art], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.art.index')
            ])

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

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $art->notes,
                'message' => $message ?? '',
            ])

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

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $art->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'       => old('image') ?? $art->image,
                'credit'    => old('image_credit') ?? $art->image_credit,
                'source'    => old('image_source') ?? $art->image_source,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $art->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
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

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.art.index')
            ])

        </form>

    </div>

@endsection
