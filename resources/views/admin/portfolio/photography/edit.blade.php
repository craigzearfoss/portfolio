@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $photo = $photo ?? null;

    $title    = $pageTitle ?? 'Edit Photography: ' . $photo->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',      'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,  'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',   'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Photography', 'href' => route('admin.portfolio.photography.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $photo->name,  'href' => route('admin.portfolio.photography.show', [$photo, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',   'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Photography', 'href' => route('admin.portfolio.photography.index') ];
        $breadcrumbs[] = [ 'name' => $photo->name,  'href' => route('admin.portfolio.photography.show', $photo) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.photography.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.photography.update', array_merge([$photo], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.photography.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $photo->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a photography */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $photo->owner_id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $photo->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'artist',
                'value'     => old('artist') ?? $photo->artist,
                'maxlength' => 255,
                'message'   => $message ?? '',
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
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'year',
                'value'     => old('year') ?? $photo->year,
                'min'       => -2000,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'credit',
                'value'     => old('credit') ?? $photo->credit,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $photo->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $photo->link,
                'name' => old('link_name') ?? $photo->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $photo->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $photo->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $photo->image,
                'credit'  => old('image_credit') ?? $photo->image_credit,
                'source'  => old('image_source') ?? $photo->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $photo->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
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

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.photography.index')
            ])

        </form>

    </div>

@endsection
