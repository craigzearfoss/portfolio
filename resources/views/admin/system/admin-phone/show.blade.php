@php
    use App\Enums\PermissionEntityTypes;

    $isRootAdmin = isRootAdmin();

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Phone: ' . $adminPhone->email : 'Phone: ' . $adminPhone->email);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                         'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                                  'href' => route('admin.system.index',
                                                                               !empty($owner)
                                                                                   ? ['owner_id'=>$owner->id]
                                                                                   : []
                                                                              )],
        [ 'name' => isRootAdmin() ? 'Admin Phone Numbers' : 'Phone Numbers', 'href' => route('admin.system.admin-phone.index') ],
        [ 'name' => isRootAdmin() ? 'Admin Phone Number' : 'Phone' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $adminPhone, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-phone.edit', $adminPhone)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'admin-phone', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Create New Phone',
                                                               'href' => route('admin.system.admin-phone.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-phone.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $adminPhone->id
            ])

            @if(!empty($adminPhone->owner))
                @include('admin.components.show-row-link', [
                    'name' => 'owner',
                    'label' => $adminPhone->owner->username,
                    'href' => route('admin.system.admin.show', $adminPhone->owner)
                ])
            @else
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => '?'
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $adminPhone->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'label',
                'value' => $adminPhone->label
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $adminPhone->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $adminPhone->notes
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $adminPhone,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($adminPhone->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($adminPhone->updated_at)
            ])

        </div>
    </div>

@endsection
