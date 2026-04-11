@php
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $adminPhone    = $adminPhone ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Add New Admin Phone Number' : 'Add New Phone Number');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                      'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                               'href' => route('admin.system.index',
                                                                                            !empty($owner)
                                                                                                ? ['owner_id'=>$owner->id]
                                                                                                : []
                                                                                            )],
        [ 'name' => $isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.admin-phone.index') ],
        [ 'name' => 'Add' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin-phone.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin-phone.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin-phone.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $owner_id ?? null,
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
                'label'      => 'Add Phone Number',
                'cancel_url' => referer('admin.system.admin-phone.index')
            ])

        </form>

    </div>

@endsection
