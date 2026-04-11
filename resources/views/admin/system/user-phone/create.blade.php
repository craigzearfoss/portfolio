@php
    use App\Models\System\User;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $userPhone   = $userPhone ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Add New User Phone Number' : 'Add New Phone Number');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                     'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                              'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.user-phone.index') ],
        [ 'name' => 'Add' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user-phone.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user-phone.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user-phone.index')
            ])

            @if($isRootAdmin)
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
                'value'     => old('phone') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'value'     => old('label') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'id'      => 'inputNotes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => $isRootAdmin ? 'Add User Phone Number' : ' Add Phone Number',
                'cancel_url' => referer('admin.system.user-phone.index')
            ])

        </form>

    </div>

@endsection
