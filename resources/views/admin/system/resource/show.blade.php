@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                 'href' => route('admin.dashboard') ],
        [ 'name' => 'Resources',                       'href' => route('admin.system.resource.index') ],
        [ 'name' => $resource->database->name . ' db', 'href' => route('admin.system.database.show', $resource->database) ],
        [ 'name' => $resource->name ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $resource, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.resource.edit', $resource) ])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.resource.index') ])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Resource: ' . $resource->database->name . '.' . $resource->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $resource->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $resource->owner->username
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
                'label'  => $resource->parent->name,
                'href'   => route('admin.system.resource.show', $resource->parent->id)
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
                                    'name' => $child->name,
                                    'href' => route('admin.system.resource.show', $child)
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
            'name'  => 'class',
            'value' => $resource->class
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $resource->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'plural',
            'value' => $resource->plural
        ])

        @include('admin.components.show-row-icon', [
            'name' => 'icon',
            'icon' => $resource->icon
        ])

        @include('admin.components.show-row-environments', [
            'resource' => $resource,
        ])

        @include('admin.components.show-row-menu-fields', [
            'menu'       => $resource->menu,
            'menu_level' => $resource->menu_level,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $resource,
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
