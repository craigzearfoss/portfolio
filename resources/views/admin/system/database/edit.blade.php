@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',       'href' => route('admin.dashboard') ],
        [ 'name' => 'Databases',             'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name . ' db', 'href' => route('admin.system.database.show', $database) ],
        [ 'name' => 'Edit' ],
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.database.index') ])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Database: ' . $database->name,
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

        <form action="{{ route('admin.system.database.update', $database) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.database.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $database->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $database->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions(
                        ['root' => 1], 'id', 'username', true, false, ['username', 'asc']
                    ),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $database->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $database->name,
                'unique'    => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'database',
                'value'     => old('database') ?? $database->database,
                'unique'    => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'tag',
                'value'     => old('tag') ?? $database->tag,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? $database->title,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'plural',
                'value'     => old('plural') ?? $database->plural,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? $database->icon,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-environments-horizontal', [
                'guest'  => old('guest')  ?? $database->guest,
                'user'   => old('user')   ?? $database->user,
                'admin'  => old('admin')  ?? $database->admin,
                'global' => old('global') ?? $database->global,
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $database->menu,
                'menu_level' => old('meni_level') ?? $database->menu_level,
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public')   ?? $database->public,
                'readonly' => old('readonly') ?? $database->readonly,
                'root'     => old('root')     ?? $database->root,
                'disabled' => old('disabled') ?? $database->disabled,
                'demo'     => old('demo')     ?? $database->demo,
                'sequence' => old('sequence') ?? $database->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.database.index')
            ])

        </form>

    </div>

@endsection
