@php
    use App\Models\System\Owner;

    $title    = $pageTitle ?? $adminPhone->phone;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                'href' => route('admin.system.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => isRootAdmin() ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.admin-phone.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => $adminPhone->phone, 'href' => route('admin.system.admin-phone.show', [$adminPhone, 'owner_id'=>$owner->id]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin-phone.index')])->render(),
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

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $adminTeam->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminTeam->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $adminTeam->owner_id
                ])
            @endif

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

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $adminTeam->image,
                'credit'  => old('image_credit') ?? $adminTeam->image_credit,
                'source'  => old('image_source') ?? $adminTeam->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $adminTeam->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $adminTeam->public,
                'readonly'    => old('readonly') ?? $adminTeam->readonly,
                'root'        => old('root')     ?? $adminTeam->root,
                'disabled'    => old('disabled') ?? $adminTeam->disabled,
                'demo'        => old('demo')     ?? $adminTeam->demo,
                'sequence'    => old('sequence') ?? $adminTeam->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-team.index')
            ])

        </form>

    </div>

@endsection
