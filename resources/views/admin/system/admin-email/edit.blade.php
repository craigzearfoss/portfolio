@php
    use App\Models\System\Owner;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit Admin Email: ' . $adminEmail->email : 'Edit Email: ' . $adminEmail->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'System',           'href' => route('admin.system.index',
                                                        !empty($owner)
                                                            ? ['owner_id'=>$owner->id]
                                                            : []
                                                       )],
        [ 'name' => $isRootAdmin ? 'Admin Email Addresses' : 'Email Addresses', 'href' => route('admin.system.admin-email.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => $adminEmail->email, 'href' => route('admin.system.admin-email.show', [$adminEmail, 'owner_id'=>$owner->id]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin-email.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-email.update', array_merge([$adminEmail], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-email.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminEmail->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email',
                'value'     => old('email') ?? $adminEmail->email,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'value'     => old('label') ?? $adminEmail->label,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $adminEmail->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'id'      => 'inputNotes',
                'value'   => old('notes') ?? $adminEmail->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('is_public')   ?? $adminEmail->public,
                'readonly'    => old('is_readonly') ?? $adminEmail->is_readonly,
                'root'        => old('is_root')     ?? $adminEmail->root,
                'disabled'    => old('is_disabled') ?? $adminEmail->disabled,
                'demo'        => old('is_demo')     ?? $adminEmail->is_demo,
                'sequence'    => old('sequence') ?? $adminEmail->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-email.index')
            ])

        </form>

    </div>

@endsection
