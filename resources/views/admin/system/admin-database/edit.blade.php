@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (isRootAdmin() && !empty($owner)) {
        $breadcrumbs[] = [ 'name' => $owner->name,                 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Databases',                  'href' => route('admin.system.admin-database.index', [ 'owner_id'=>$owner->id ]) ];
        $breadcrumbs[] = [ 'name' => $adminDatabase->name . ' db', 'href' => route('admin.system.admin-database.show', [ $adminDatabase, 'owner_id'=>$owner->id ]) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [];
    if (isRootAdmin() && !empty($owner)) {
        $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-database.index', [ 'owner_id'=>$owner->id ]) ])->render();
    } else {
        $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-database.index') ])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Database: ' . $adminDatabase->name . ' db for ' . $adminDatabase->owner->name,
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

        <form action="{{ route('admin.system.admin-database.update', (isRootAdmin() && !empty($owner)) ? [ $adminDatabase, 'owner_id'=>$owner->id ] : [ $adminDatabase ]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-database.index', (isRootAdmin() && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

            @if($admin->root)

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $adminDatabase->id
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminDatabase->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions(
                        ['root' => 1], 'id', 'username', true, false, ['username', 'asc']
                    ),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $adminDatabase->name,
                    'unique'    => true,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'database',
                    'value'     => old('database') ?? $adminDatabase->database,
                    'unique'    => true,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'tag',
                    'value'     => old('tag') ?? $adminDatabase->tag,
                    'required'  => true,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'title',
                    'value'     => old('title') ?? $adminDatabase->title,
                    'required'  => true,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'plural',
                    'value'     => old('plural') ?? $adminDatabase->plural,
                    'required'  => true,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'icon',
                    'value'     => old('icon') ?? $adminDatabase->icon,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

            @else

                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminDatabase->owner_id
                ])

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                {{ $adminDatabase->name }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">database</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                {{ $adminDatabase->database }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">tag</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                {{ $adminDatabase->tag }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">title</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                {{ $adminDatabase->title }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">plural</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                {{ $adminDatabase->plural }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">icon</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                <span class="text-xl">
                                    <i class="fa-solid {{ $adminDatabase->icon }}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @include('admin.components.form-environments-horizontal', [
                'guest'  => old('guest')  ?? $adminDatabase->guest,
                'user'   => old('user')   ?? $adminDatabase->user,
                'admin'  => old('admin')  ?? $adminDatabase->admin,
                'global' => old('global') ?? $adminDatabase->global,
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $adminDatabase->menu,
                'menu_level' => old('meni_level') ?? $adminDatabase->menu_level,
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'     => old('public')   ?? $adminDatabase->public,
                'readonly'    => old('readonly') ?? $adminDatabase->readonly,
                'root'        => old('root')     ?? $adminDatabase->root,
                'disabled'    => old('disabled') ?? $adminDatabase->disabled,
                'demo'        => old('demo')     ?? $adminDatabase->demo,
                'sequence'    => old('sequence') ?? $adminDatabase->sequence,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-database.index', (isRootAdmin() && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

        </form>

    </div>

@endsection
