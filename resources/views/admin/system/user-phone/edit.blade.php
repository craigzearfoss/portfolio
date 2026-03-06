@php
    use App\Models\System\User;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit User Phone: ' . $adminPhone->phone : 'Edit Phone: ' . $adminPhone->phone);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                  'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                       'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                                'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.user-phone.index') ],
        [ 'name' => $userPhone->phone, 'href' => route('admin.system.user-phone.show', [$userPhone]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user-phone.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user-phone.update', array_merge([$userPhone], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user-phone.index')
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'user_id',
                    'label'    => 'user',
                    'value'    => old('user_id') ?? $userPhone->user_id,
                    'required' => true,
                    'list'     => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'user_id',
                    'value' => Auth::guard('user')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? $userPhone->phone,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'value'     => old('label') ?? $userPhone->label,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $userPhone->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'id'      => 'inputNotes',
                'value'   => old('notes') ?? $userPhone->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('is_public')   ?? $userPhone->public,
                'readonly'    => old('is_readonly') ?? $userPhone->is_readonly,
                'root'        => old('is_root')     ?? $userPhone->root,
                'disabled'    => old('is_disabled') ?? $userPhone->disabled,
                'demo'        => old('is_demo')     ?? $userPhone->is_demo,
                'sequence'    => old('sequence') ?? $userPhone->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.user-phone.index')
            ])

        </form>

    </div>

@endsection
