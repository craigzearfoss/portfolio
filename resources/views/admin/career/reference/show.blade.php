@extends('admin.layouts.default', [
    'title' => $reference->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'References',      'url' => route('admin.career.reference.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'url' => route('admin.career.reference.edit', $reference) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reference', 'url' => route('admin.career.reference.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'url' => route('admin.career.reference.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card form-container">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $reference->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $reference->slug
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->phone_label) ? $reference->phone_label : 'phone',
            'value' => $reference->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_phone_label) ? $reference->alt_phone_label : 'alt phone',
            'value' => $reference->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->email_label) ? $reference->email_label : 'email',
            'value' => $reference->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_email_label) ? $reference->alt_email_label : 'alt email',
            'value' => $reference->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $reference->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $reference->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $reference->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $reference->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $reference->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $reference->image_source
        ])

        @include('admin.components.show-row', [
            'name'  => 'thumbnail',
            'value' => $reference->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $reference->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $reference->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $reference->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $reference->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $reference->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($reference->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($reference->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($reference->deleted_at)
        ])

    </div>

@endsection
