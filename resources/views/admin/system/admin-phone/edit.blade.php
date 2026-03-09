@php
    use App\Models\System\Owner;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit Admin Phone: ' . $adminPhone->phone : 'Edit Phone: ' . $adminPhone->phone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                'href' => route('admin.system.index',
                                                                                             !empty($owner)
                                                                                                 ? ['owner_id'=>$owner->id]
                                                                                                 : []
                                                                                             )],
        [ 'name' => $isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.admin-phone.index', ['owner_id'=>$owner->id]) ],
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

        <form action="{{ route('admin.system.admin-phone.update', array_merge([$adminPhone], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-phone.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $adminPhone->owner_id,
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
                'name'      => 'phone',
                'value'     => old('phone') ?? $adminPhone->phone,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'value'     => old('label') ?? $adminPhone->label,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $adminPhone->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'id'      => 'inputNotes',
                'value'   => old('notes') ?? $adminPhone->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $adminPhone->public,
                'is_readonly' => old('is_readonly') ?? $adminPhone->is_readonly,
                'is_root'     => old('is_root')     ?? $adminPhone->root,
                'is_disabled' => old('is_disabled') ?? $adminPhone->disabled,
                'is_demo'     => old('is_demo')     ?? $adminPhone->is_demo,
                'sequence'    => old('sequence') ?? $adminPhone->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.admin-phone.index')
            ])

        </form>

    </div>

@endsection
