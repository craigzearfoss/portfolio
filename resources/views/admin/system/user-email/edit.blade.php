@php
    use App\Models\System\User;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Edit User Email: ' . $userEmail->email : 'Edit Email: ' . $userEmail->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Email Addresses' : 'Email Addresses', 'href' => route('admin.system.user-email.index') ],
        [ 'name' => $userEmail->email, 'href' => route('admin.system.user-email.show', [$userEmail]) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user-email.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user-email.update', array_merge([$userEmail], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user-email.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'user_id',
                    'label'    => 'user',
                    'value'    => old('user_id') ?? $userEmail->user_id,
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
                'name'      => 'email',
                'value'     => old('email') ?? $userEmail->email,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'value'     => old('label') ?? $userEmail->label,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $userEmail->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'id'      => 'inputNotes',
                'value'   => old('notes') ?? $userEmail->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('is_public')   ?? $userEmail->public,
                'readonly'    => old('is_readonly') ?? $userEmail->is_readonly,
                'root'        => old('is_root')     ?? $userEmail->root,
                'disabled'    => old('is_disabled') ?? $userEmail->disabled,
                'demo'        => old('is_demo')     ?? $userEmail->is_demo,
                'sequence'    => old('sequence') ?? $userEmail->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.systemuser-email.index')
            ])

        </form>

    </div>

@endsection
