@extends('admin.layouts.default', [
    'title' => $reading->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Readings']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.portfolio.reading.edit', $reading) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reading', 'url' => route('admin.portfolio.reading.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => route('admin.portfolio.reading.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        <div>
            @include('admin.components.messages', [$errors])
        </div>

        @if ($errors->any())
            @include('admin.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-solid btn-sm"
               href="{{ route('admin.portfolio.reading.edit', $reading) }}"><i
                    class="fa fa-pen-to-square"></i> Edit</a>
            <a class="btn btn-solid btn-sm" href="{{ route('admin.portfolio.reading.index') }}"><i
                    class="fa fa-arrow-left"></i> Back</a>
        </div>

        <div class="row">

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $reading->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $reading->slug
            ])

            @include('admin.components.show-row', [
                'name'  => 'author',
                'value' => $reading->author
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'professional',
                'checked' => $reading->professional
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'personal',
                'checked' => $reading->personal
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'paper',
                'checked' => $reading->paper
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'audio',
                'checked' => $reading->audio
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'wishlist',
                'label'   => 'wish list',
                'checked' => $reading->wishlist
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'url'    => $reading->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'link name',
                'value' => $reading->link_name
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $reading->notes
            ])

            @include('admin.components.show-row', [
                'name'  => 'sequence',
                'value' => $reading->sequence
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'public',
                'checked' => $reading->public
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'disabled',
                'checked' => $reading->disabled
            ])

            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $reading->admin['username'] ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($reading->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($reading->updated_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'deleted at',
                'value' => longDateTime($reading->deleted_at)
            ])

        </div>

@endsection
