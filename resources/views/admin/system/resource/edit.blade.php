@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                 'href' => route('admin.dashboard') ],
        [ 'name' => 'Resources',                       'href' => route('admin.system.resource.index') ],
        [ 'name' => $resource->database->name . ' db', 'href' => route('admin.system.database.show', $resource->database) ],
        [ 'name' => $resource->name,                   'href' => route('admin.system.resource.show', $resource) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.resource.index') ])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Resource: ' . $resource->database->name . '.' . $resource->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.resource.update', $resource) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.resource.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $resource->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $resource->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions(
                        ['root' => 1], 'id', 'username', true, false, ['username', 'asc']
                    ),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $resource->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $resource->name,
                'unique'    => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'resource_database_id',
                'label'    => 'database',
                'value'    => old('resource_db_id') ?? $resource->database_id,
                'required' => true,
                'list'     => \App\Models\System\Database::listOptions([]),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'table',
                'value'     => old('table') ?? $resource->table,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'class',
                'value'     => old('class') ?? $resource->class,
                'unique'    => true,
                'maxlength' => 255,
                'disabled'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? $resource->title,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'plural',
                'value'     => old('plural') ?? $resource->plural,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? $resource->icon,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-environments-horizontal', [
                'guest'  => old('guest')  ?? $resource->guest,
                'user'   => old('user')   ?? $resource->user,
                'admin'  => old('admin')  ?? $resource->admin,
                'global' => old('global') ?? $resource->global,
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $resource->menu,
                'menu_level' => old('meni_level') ?? $resource->menu_level,
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public')   ?? $resource->public,
                'readonly' => old('readonly') ?? $resource->readonly,
                'root'     => old('root')     ?? $resource->root,
                'disabled' => old('disabled') ?? $resource->disabled,
                'demo'     => old('demo')     ?? $resource->demo,
                'sequence' => old('sequence') ?? $resource->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.resource.index')
            ])

        </form>

    </div>

@endsection
