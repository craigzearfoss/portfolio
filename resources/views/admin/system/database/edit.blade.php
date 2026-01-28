@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Database: ' . $database->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Databases',       'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.database.index') ])->render(),
    ],
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

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'guest',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('guest') ?? $database->guest,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'user',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('user') ?? $database->user,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'admin',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('admin') ?? $database->admin,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'global',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('global') ?? $database->global,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'menu',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('menu') ?? $database->menu,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-input', [
                                'name'      => 'menu_level',
                                'label'     => 'menu level',
                                'type'      => 'number',
                                'value'     => old('menu_level') ?? $database->menu_level,
                                'required'  => true,
                                'message'   => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? $database->icon,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $database->public,
                'readonly' => old('readonly') ?? $database->readonly,
                'root'     => old('root') ?? $database->root,
                'disabled' => old('disabled') ?? $database->disabled,
                'demo'     => old('demo') ?? $database->demo,
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
