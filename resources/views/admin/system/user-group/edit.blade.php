@php
    use App\Models\System\Owner;
    use App\Models\System\UserTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $userGroup   = $userGroup ?? null;

    $title    = !$isRootAdmin
        ? str_replace('UserGroup', 'Group', 'Edit ' . getResourcePageTitle($userGroup))
        : 'Edit ' . getResourcePageTitle($userGroup);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Groups' : 'Groups', 'href' => route('admin.system.user-group.index') ],
        [ 'name' => $userGroup->name,                        'href' => route('admin.system.user-group.show', $userGroup) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-group.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.system.user-group.update', array_merge([$userGroup], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.system.user-group.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $userGroup->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $userGroup->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $userGroup->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $userGroup->owner_id
                    ])
                @endif

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'admin_team_id',
                    'label'   => 'team',
                    'value'   => old('admin_team_id') ?? $userGroup->team['id'] ?? '',
                    'list'    => new UserTeam()->listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $userGroup->name,
                    'required'  => true,
                    'minlength' => 3,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'abbreviation',
                    'value'     => old('abbreviation') ?? $userGroup->abbreviation,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $userGroup->description,
                    'message' => $message ?? '',
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $userGroup,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $userGroup->is_public,
                    'is_readonly' => old('is_readonly') ?? $userGroup->is_readonly,
                    'is_root'     => old('is_root')     ?? $userGroup->root,
                    'is_disabled' => old('is_disabled') ?? $userGroup->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $userGroup->is_demo,
                    'sequence'    => old('sequence')    ?? $userGroup->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.system.system.admin-user.index')
        ])

    </form>

@endsection
