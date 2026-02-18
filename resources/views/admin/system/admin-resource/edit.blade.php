@php
    use App\Models\System\Owner;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Resources',       'href' => route('admin.system.resource.index') ],
        [ 'name' => $resource->name,   'href' => route('admin.system.resource.show', $resource->id) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [];
    if (isRootAdmin() && !empty($owner)) {
        $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index', [ 'owner_id'=>$owner->id ]) ])->render();
    } else {
        $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index') ])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? $adminResource->database->name . '.' . $adminResource->name . ' Resource',
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

        <form
            action="{{ route('admin.system.admin-resource.update', array_merge([$adminResource], request()->all())) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.resource.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $adminResource->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminResource->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([ 'root' => 1 ], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminResource->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $adminResource->name,
                'unique'    => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'resource_database_id',
                'label'    => 'database',
                'value'    => old('resource_db_id') ?? $adminResource->database_id,
                'required' => true,
                'list'     => \App\Models\System\Database::listOptions([]),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'table',
                'value'     => old('table') ?? $adminResource->table,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'class',
                'value'     => old('class') ?? $adminResource->class,
                'unique'    => true,
                'maxlength' => 255,
                'disabled'  => true,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? $adminResource->title,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'plural',
                'value'     => old('plural') ?? $adminResource->plural,
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? $adminResource->icon,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-environments-horizontal', [
                'guest'  => old('guest')  ?? $adminResource->guest,
                'user'   => old('user')   ?? $adminResource->user,
                'admin'  => old('admin')  ?? $adminResource->admin,
                'global' => old('global') ?? $adminResource->global,
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $adminResource->menu,
                'menu_level' => old('meni_level') ?? $adminResource->menu_level,
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public')   ?? $adminResource->public,
                'readonly' => old('readonly') ?? $adminResource->readonly,
                'root'     => old('root')     ?? $adminResource->root,
                'disabled' => old('disabled') ?? $adminResource->disabled,
                'demo'     => old('demo')     ?? $adminResource->demo,
                'sequence' => old('sequence') ?? $adminResource->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.resource.index', (isRootAdmin() && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

        </form>

    </div>

@endsection
