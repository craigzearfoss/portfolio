@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Sessions' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Sessions',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => [],
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>admin_id</th>
                <th>ip_address</th>
                <th>last_activity</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>user_id</th>
                    <th>admin_id</th>
                    <th>ip_address</th>
                    <th>last_activity</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($sessions as $session)

                <tr data-id="{{ $session->id }}">
                    <td data-field="id">
                        {{ $session['id'] }}
                    </td>
                    <td data-field="user_id">
                        {{ $session->user_id }}
                    </td>
                    <td data-field="admin_id">
                        {{ $session->admin_id }}
                    </td>
                    <td data-field="ip_address">
                        {!! $session->ip_address !!}
                    </td>
                    <td data-field="last_activity">
                        {!! $session->last_activity !!}
                    </td>
                    <td>
                        <a class="button is-small px-1 py-0" href="{!! route('admin.session.show', $session->id) !!}">
                            <i class="fa-solid fa-list"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no sessions.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $sessions->links('vendor.pagination.bulma') !!}

    </div>

@endsection
