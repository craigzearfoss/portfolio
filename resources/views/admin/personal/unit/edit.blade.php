@php
    use App\Models\Personal\Unit;

    $title    = $pageTitle ?? 'Edit Unit: ' . $unit->name;
    $subtitle = $title;

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
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.unit.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

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
                'list'    => new Unit()->listOptions([], 'system', 'system', true),
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

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $unit->is_public,
                'is_readonly' => old('is_readonly') ?? $unit->is_readonly,
                'is_root'     => old('is_root')     ?? $unit->root,
                'is_disabled' => old('is_disabled') ?? $unit->is_disabled,
                'is_demo'     => old('is_demo')     ?? $unit->is_demo,
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
