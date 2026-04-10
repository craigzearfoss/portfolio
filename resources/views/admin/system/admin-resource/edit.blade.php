@php
    use App\Models\System\Database;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Admin Resource: ' .  $adminResource->database->name . '.' . $adminResource->name;
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
        [ 'name' => 'Resources',          'href' => route('admin.system.resource.index') ],
        [ 'name' => $adminResource->name, 'href' => route('admin.system.resource.show', $adminResource->id) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if ($isRootAdmin && !empty($owner)) {
        $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index', [ 'owner_id'=>$owner->id ]) ])->render();
    } else {
        $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index') ])->render();
    }
@endphp

@extends('admin.layouts.default')

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
                'value' => $adminResource->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of an admin resource */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $adminResource->owner_id
            ])

            @include('admin.components.form-text-horizontal', [
                'name'      => 'name',
                'value'     => $adminResource->name,
            ])

            @if($isRootAdmin)

                @include('admin.components.form-text-horizontal', [
                    'name'      => 'database',
                    'value'     => $adminResource->database['name'] ?? '?',
                ])

                @include('admin.components.form-text-horizontal', [
                    'name'      => 'table',
                    'value'     => $adminResource->table_name,
                ])

                @include('admin.components.form-text-horizontal', [
                    'name'      => 'class',
                    'value'     => $adminResource->class,
                ])

            @endif

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

            @if ($isRootAdmin)

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label" for="has_owner">has owner</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control ">
                                <span>
                                    @include('admin.components.checkbox', [ 'checked' => $adminResource->has_owner ])
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @include('admin.components.form-environments-horizontal', [
                'guest'  => old('guest')  ?? $adminResource->guest,
                'user'   => old('user')   ?? $adminResource->user,
                'admin'  => old('admin')  ?? $adminResource->admin,
            ])

            @include('admin.components.form-menu-fields-horizontal', [
                'menu'       => old('menu')       ?? $adminResource->menu,
                'menu_level' => old('menu_level') ?? $adminResource->menu_level,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $adminResource->is_public,
                'is_readonly' => old('is_readonly') ?? $adminResource->is_readonly,
                'is_root'     => old('is_root')     ?? $adminResource->is_root,
                'is_disabled' => old('is_disabled') ?? $adminResource->is_disabled,
                'is_demo'     => old('is_demo')     ?? $adminResource->is_demo,
                'sequence'    => old('sequence')    ?? $adminResource->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.resource.index', ($isRootAdmin && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : [])
            ])

        </form>

    </div>

@endsection
