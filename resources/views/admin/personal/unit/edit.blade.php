@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units',           'href' => route('admin.personal.unit.index') ],
        [ 'name' => $unit->name,       'href' => route('admin.personal.unit.show', $unit) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.unit.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Unit: ' . $unit->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.unit.update', array_merge([$unit], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.unit.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $unit->id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $unit->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $unit->abbreviation,
                'maxlength' => 10,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'system',
                'value'   => old('system') ?? $unit->system,
                'list'    => \App\Models\Personal\Unit::listOptions([], 'system', 'system', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $unit->link,
                'name' => old('link_name') ?? $unit->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $unit->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $unit->image,
                'credit'  => old('image_credit') ?? $unit->image_credit,
                'source'  => old('image_source') ?? $unit->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $unit->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $unit->public,
                'readonly'    => old('readonly') ?? $unit->readonly,
                'root'        => old('root')     ?? $unit->root,
                'disabled'    => old('disabled') ?? $unit->disabled,
                'demo'        => old('demo')     ?? $unit->demo,
                'sequence'    => old('sequence') ?? $unit->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.unit.index')
            ])

        </form>

    </div>

@endsection
