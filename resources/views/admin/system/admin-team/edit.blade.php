@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminTeam     = $adminTeam ?? null;

    $title    = !$isRootAdmin
        ? str_replace('AdminTeam', 'Team', 'Edit ' . getResourcePageTitle($adminTeam))
        : 'Edit ' . getResourcePageTitle($adminTeam);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                      'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                               'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Teams' : 'Teams', 'href' => route('admin.system.admin-team.index') ],
        [ 'name' => $adminTeam->name,                       'href' => route('admin.system.admin-team.show', $adminTeam) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-team.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-team.update', array_merge([$adminTeam], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-team.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? $adminTeam->favorite_count,
                ])
            @endif

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $adminTeam->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of an admin team */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $adminTeam->owner_id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $adminTeam->name,
                'required'  => true,
                'minlength' => 3,
                'maxlength' => 200,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $adminTeam->abbreviation,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $adminTeam->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.show-row-images', [
                'resource' => $adminTeam,
                'upload'   => false,
                'download' => true,
                'external' => true,
                'editPage' => true,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $adminTeam->is_public,
                'is_readonly' => old('is_readonly') ?? $adminTeam->is_readonly,
                'is_root'     => old('is_root')     ?? $adminTeam->root,
                'is_disabled' => old('is_disabled') ?? $adminTeam->is_disabled,
                'demo'        => old('is_demo')     ?? $adminTeam->is_demo,
                'sequence'    => old('sequence')    ?? $adminTeam->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-team.index')
            ])

        </form>

    </div>

@endsection
