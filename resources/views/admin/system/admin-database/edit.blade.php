@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminDatabase = $adminDatabase ?? null;

    $title    = $pageTitle ?? $adminDatabase->owner->name . ' Database';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
        [ 'name' => 'System',             'href' => route('admin.system.index',
                                                          !empty($owner)
                                                              ? ['owner_id'=>$owner->id]
                                                              : []
                                                         )],
        [ 'name' => 'Databases',          'href' => route('admin.system.admin-database.index') ],
        [ 'name' => $adminDatabase->name, 'href' => route('admin.system.admin-database.show', $adminDatabase->id) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if ($isRootAdmin && !empty($owner)) {
        $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-database.index', [ 'owner_id'=>$owner->id ]) ])->render();
    } else {
        $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-database.index') ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form
            action="{{ route('admin.system.admin-database.update', array_merge([$adminDatabase], request()->all())) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-database.index', ($isRootAdmin && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

            @if($isRootAdmin)

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $adminDatabase->id,
                    'hide'  => !$isRootAdmin,
                ])

                    <?php /* note that you CANNOT change the owner of an admin database */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminDatabase->owner_id
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
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $adminDatabase->menu,
                'menu_level' => old('menu_level') ?? $adminDatabase->menu_level,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $adminDatabase->public,
                'is_readonly' => old('is_readonly') ?? $adminDatabase->is_readonly,
                'is_root'     => old('is_root')     ?? $adminDatabase->root,
                'is_disabled' => old('is_disabled') ?? $adminDatabase->disabled,
                'is_demo'     => old('is_demo')     ?? $adminDatabase->is_demo,
                'sequence'    => old('sequence')    ?? $adminDatabase->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-database.index', ($isRootAdmin && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

        </form>

    </div>

@endsection
