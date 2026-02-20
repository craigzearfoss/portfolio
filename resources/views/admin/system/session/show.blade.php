@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Session: ' . $session->id,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Sessions',        'href' => route('admin.system.session.index') ],
        [ 'name' => $session->id ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.session.index' )])->render(),
    ],
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $session->id
            ])

            @include('admin.components.show-row', [
                'name'  => 'user_id',
                'value' => $session->user_id
            ])

            @include('admin.components.show-row', [
                'name'  => 'admin_id',
                'value' => $session->admin_id
            ])

            @include('admin.components.show-row', [
                'name'  => 'ip_address',
                'value' => $session->ip_address ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'last_activity',
                'value' => $session->last_activity
            ])

        </div>
    </div>

@endsection
