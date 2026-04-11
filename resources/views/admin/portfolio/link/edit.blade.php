@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $link        = $link ?? null;

    $title    = $pageTitle ?? 'Edit Link: ' . $link->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Links',      'href' => route('admin.portfolio.link.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $link->name,  'href' => route('admin.portfolio.link.show', [$link, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Links',      'href' => route('admin.portfolio.link.index') ];
        $breadcrumbs[] = [ 'name' => $link->name,  'href' => route('admin.portfolio.link.show', $link) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.link.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.link.update', array_merge([$link], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.link.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $link->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a link */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $link->owner_id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $link->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $link->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $link->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'url',
                'value'     => old('url') ?? $link->url,
                'required'  => true,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $link->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $link->link,
                'name' => old('link_name') ?? $link->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $link->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $link->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $link->image,
                'credit'  => old('image_credit') ?? $link->image_credit,
                'source'  => old('image_source') ?? $link->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $link->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $link->is_public,
                'is_readonly' => old('is_readonly') ?? $link->is_readonly,
                'is_root'     => old('is_root')     ?? $link->is_root,
                'is_disabled' => old('is_disabled') ?? $link->is_disabled,
                'is_demo'     => old('is_demo')     ?? $link->is_demo,
                'sequence'    => old('sequence')    ?? $link->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.link.index')
            ])

        </form>

    </div>

@endsection
