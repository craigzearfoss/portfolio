@php
    use App\Models\System\AdminTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminGroup    = $adminGroup ?? null;

    $title    = !$isRootAdmin
        ? str_replace('AdminGroup', 'Group', 'Edit ' . getResourcePageTitle($adminGroup))
        : 'Edit ' . getResourcePageTitle($adminGroup);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                        'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                 'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Groups' : 'Groups', 'href' => route('admin.system.admin-group.index') ],
        [ 'name' => $adminGroup->name,                        'href' => route('admin.system.admin-group.show', $adminGroup) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-group.index') ])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-group.update', array_merge([$adminGroup], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-group.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? $adminEmail->favorite_count,
                ])
            @endif

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $adminGroup->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of am admin group */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $adminGroup->owner_id
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'admin_team_id',
                'label'   => 'team',
                'value'   => old('admin_team_id') ?? $adminGroup->team['id'] ?? '',
                'list'    => new AdminTeam()->listOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $adminGroup->name,
                'required'  => true,
                'minlength' => 3,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $adminGroup->abbreviation,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $adminGroup->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.show-row-images', [
                'resource' => $adminGroup,
                'upload'   => false,
                'download' => true,
                'external' => true,
                'editPage' => true,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $adminGroup->is_public,
                'is_readonly' => old('is_readonly') ?? $adminGroup->is_readonly,
                'is_root'     => old('is_root')     ?? $adminGroup->root,
                'is_disabled' => old('is_disabled') ?? $adminGroup->is_disabled,
                'is_demo'     => old('is_demo')     ?? $adminGroup->is_demo,
                'sequence'    => old('sequence')    ?? $adminGroup->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-group.index')
            ])

        </form>

    </div>

@endsection
