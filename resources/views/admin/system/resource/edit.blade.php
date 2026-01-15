@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Resource: ' . $resource->database->name . '.' . $resource->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Resources',       'href' => route('root.resource.index') ],
        [ 'name' => $resource->database->name . '.' . $resource->name ],
    ],
    'buttons'          => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('root.resource.index') ],
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('root.resource.update', $resource) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('root.resource.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $resource->id
            ])

            @if(isRootAdmin())
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
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox', [
                'name'            => 'has_owner',
                'label'           => 'has owner',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('has_owner') ?? $resource->has_owner,
                'disabled'        => true,
                'message'         => $message ?? '',
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
                                'checked'         => old('guest') ?? $resource->guest,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'user',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('user') ?? $resource->user,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'admin',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('admin') ?? $resource->admin,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'global',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('global') ?? $resource->global,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'menu',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('menu') ?? $resource->menu,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-input', [
                                'name'      => 'menu_level',
                                'label'     => 'menu level',
                                'type'      => 'number',
                                'value'     => old('menu_level') ?? $resource->menu_level,
                                'required'  => true,
                                'message'   => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? $resource->icon,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $resource->public,
                'readonly' => old('readonly') ?? $resource->readonly,
                'root'     => old('root') ?? $resource->root,
                'disabled' => old('disabled') ?? $resource->disabled,
                'demo'     => old('demo') ?? $resource->demo,
                'sequence' => old('sequence') ?? $resource->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('root.resource.index')
            ])

        </form>

    </div>

@endsection
