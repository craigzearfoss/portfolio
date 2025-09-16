@extends('admin.layouts.default', [
    'title' => $stack->name . ' stack',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks',          'url' => route('admin.dictionary.stack.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.dictionary.stack.edit', $stack) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Stack', 'url' => route('admin.dictionary.stack.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => Request::header('referer') ?? route('admin.dictionary.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $stack->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $stack->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $stack->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $stack->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $stack->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $stack->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $stack->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'url'    => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $stack->link,
            'label'  => $stack->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $stack->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $stack->image,
            'alt'   => $stack->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $stack->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $stack->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $stack->thumbnail,
            'alt'   => $stack->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $stack->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $stack->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $stack->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $stack->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $stack->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($stack->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($stack->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($stack->deleted_at)
        ])

    </div>

@endsection
