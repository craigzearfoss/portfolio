@php
    use App\Models\System\AdminTeam;
    use App\Models\System\Owner;

    $title    = $pageTitle ??'Edit Admin Group: ' . $adminGroup->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index',
                                                       !empty($owner)
                                                           ? ['owner_id'=>$owner->id]
                                                           : []
                                                      )],
        [ 'name' => 'Groups',          'href' => route('admin.system.admin-group.index') ],
        [ 'name' => $adminGroup->name, 'href' => route('admin.system.admin-group.show', $adminGroup->id) ],
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

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $adminGroup->id
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminGroup->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminGroup->owner_id
                ])
            @endif

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

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $adminGroup->image,
                'credit'  => old('image_credit') ?? $adminGroup->image_credit,
                'source'  => old('image_source') ?? $adminGroup->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $adminGroup->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('is_public')   ?? $adminGroup->is_public,
                'readonly'    => old('is_readonly') ?? $adminGroup->is_readonly,
                'root'        => old('is_root')     ?? $adminGroup->root,
                'disabled'    => old('is_disabled') ?? $adminGroup->is_disabled,
                'demo'        => old('is_demo')     ?? $adminGroup->is_demo,
                'sequence'    => old('sequence') ?? $adminGroup->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-group.index')
            ])

        </form>

    </div>

@endsection
