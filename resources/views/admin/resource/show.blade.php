@extends('admin.layouts.default', [
    'title' => 'Resource',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Resources',       'href' => route('admin.resource.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',    'href' => route('admin.resource.edit', $resource) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resource', 'href' => route('admin.resource.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',       'href' => referer('admin.resource.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $resource->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'database',
            'value' => $resource->database->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resource->name
        ])

        @if(!empty($resource->parent))
            @include('admin.components.show-row-link', [
                'name'   => 'parent',
                'label'  => $resource->parent['name'],
                'href'   => route('admin.resource.show', $resource->parent['id'])
            ])
        @else
            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => ''
            ])
        @endif

        <div class="columns">
            <div class="column is-2"><strong>children</strong>:</div>
            <div class="column is-10 pl-0">
                @if(!empty($resource->children))
                    <ol>
                        @foreach($resource->children as $child)
                            <li>
                                @include('admin.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('admin.resource.show', $child)
                                ])
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        @include('admin.components.show-row', [
            'name'  => 'table',
            'value' => $resource->table
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $resource->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'plural',
            'value' => $resource->plural
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'guest',
            'checked' => $resource->guest
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'user',
            'checked' => $resource->user
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'admin',
            'checked' => $resource->admin
        ])

        @include('admin.components.show-row-icon', [
            'name' => 'icon',
            'icon' => $resource->icon
        ])

        @include('admin.components.show-row', [
            'name'  => 'level',
            'value' => $resource->level
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $resource->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $resource->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $resource->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $resource->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $resource->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($resource->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($resource->updated_at)
        ])

    </div>

@endsection
