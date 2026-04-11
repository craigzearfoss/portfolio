@php
    use App\Models\System\Database;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $resource     = $resource ?? null;

    $title    = $pageTitle ?? 'Edit Resource: ' .  $resource->database->name . '.' . $resource->namecxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                        'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                             'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                      'href' => route('admin.system.index') ],
        [ 'name' => 'Resources',                                   'href' => route('admin.system.resource.index') ],
        [ 'name' => $resource->database->name.'.'.$resource->name, 'href' => route('admin.system.resource.show', $resource->id) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.resource.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.resource.update', array_merge([$resource], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.resource.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $resource->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a resource */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $resource->owner_id
            ])

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
                'list'     => new Database()->listOptions([]),
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
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $resource->menu,
                'menu_level' => old('menu_level') ?? $resource->menu_level,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $resource->is_public,
                'is_readonly' => old('is_readonly') ?? $resource->is_readonly,
                'is_root'     => old('is_root')     ?? $resource->root,
                'is_disabled' => old('is_disabled') ?? $resource->is_disabled,
                'is_demo'     => old('is_demo')     ?? $resource->is_demo,
                'sequence'    => old('sequence')    ?? $resource->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.resource.index')
            ])

        </form>

    </div>

@endsection
