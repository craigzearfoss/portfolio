@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'User Group: ' . $userGroup->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'User Groups',     'href' => route('admin.system.user-group.index') ],
        [ 'name' => $userGroup->name ]
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user-group.index') ])->render(),
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

        <form action="{{ route('admin.system.user-group.update', $userGroup->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user-group.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $userGroup->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $userGroup->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([],
                                                                        'id',
                                                                        'username',
                                                                        true,
                                                                        false,
                                                                        [ 'username', 'asc' ]
                                                                       ),
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
                'list'    => \App\Models\System\UserTeam::listOptions(),
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

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $userGroup->image,
                'credit'  => old('image_credit') ?? $userGroup->image_credit,
                'source'  => old('image_source') ?? $userGroup->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $userGroup->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $userGroup->public,
                'readonly'    => old('readonly') ?? $userGroup->readonly,
                'root'        => old('root')     ?? $userGroup->root,
                'disabled'    => old('disabled') ?? $userGroup->disabled,
                'demo'        => old('demo')     ?? $userGroup->demo,
                'sequence'    => old('sequence') ?? $userGroup->sequence,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.system.admin-user.index')
            ])

        </form>

    </div>

@endsection
