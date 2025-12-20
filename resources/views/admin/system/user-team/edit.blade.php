@extends('admin.layouts.default', [
    'title'         => 'User Team: ' . $userTeam->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Teams',      'href' => route('admin.system.user-team.index') ],
        [ 'name' => $userTeam->name ]
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.user-team.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user-team.update', $userTeam->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user-team.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $userTeam->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $userTeam->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $userTeam->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $userTeam->name,
                'required'  => true,
                'minlength' => 3,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'abbreviation',
                'value'     => old('abbreviation') ?? $userTeam->abbreviation,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $userTeam->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $userTeam->image,
                'credit'  => old('image_credit') ?? $userTeam->image_credit,
                'source'  => old('image_source') ?? $userTeam->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $userTeam->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $userTeam->public,
                'readonly' => old('readonly') ?? $userTeam->readonly,
                'root'     => old('root') ?? $userTeam->root,
                'disabled' => old('disabled') ?? $userTeam->disabled,
                'demo'     => old('demo') ?? $userTeam->demo,
                'sequence' => old('sequence') ?? $userTeam->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.user-team.index')
            ])

        </form>

    </div>

@endsection
