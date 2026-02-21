@php
    use App\Models\System\Admin;

    $title    = $pageTitle ?? 'Log';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Log' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! route('admin.system.log.index') !!}" method="get">
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'type',
                    'value'    => $type ?? '',
                    'list'     => [
                        'admin' => 'admin',
                        'user'  => 'user',
                    ],
                    'style'    => 'width: 5rem;',
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'username',
                    'value'    => Request::get('username'),
                    'list'     => new Admin()->listOptions([], 'username', 'username', true, false, [ 'username', 'asc' ]),
                    'style'    => 'width: 10rem;',
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'action',
                    'value'    => Request::get('action'),
                    'list'     => [
                        ''       => '',
                        'login'  => 'login',
                        'logout' => 'logout',
                    ],
                    'style'    => 'width: 5rem;',
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
            <div class="control">
                @include('admin.components.form-input', [
                    'name'     => 'ip_address',
                    'label'    => 'ip address',
                    'value'    => Request::get('ip_address'),
                    'style'    => 'width: 10rem; height: 1.8em',
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'success',
                    'value'    => Request::get('success'),
                    'list'     => [
                        '' => '',
                        0  => 'no',
                        1  => 'yes',
                    ],
                    'style'    => 'width: 5rem;',
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
        </form>
    </div>

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $loginAttempts->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>type</th>
                    <th>id</th>
                    <th>username</th>
                    <th>action</th>
                    <th>ip address</th>
                    <th>success</th>
                    <th>datetime</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        <th>type</th>
                        <th>id</th>
                        <th>username</th>
                        <th>action</th>
                        <th>ip address</th>
                        <th>success</th>
                        <th>datetime</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($loginAttempts as $loginAttempt)

                    <tr data-id="{{ $loginAttempt->id }}" style="line-height: 1;">
                        <td data-field="type">
                            {!! $type !!}
                        </td>
                        <td data-field="{{ $type == 'admin' ? 'admin_id' : 'user_id' }}" class="pt-0 pb-0 has-text-right">
                            {!! $type == 'admin' ? $loginAttempt->admin_id : $loginAttempt->user_id !!}
                        </td>
                        <td data-field="username" class="pt-0 pb-0">
                            {!! $loginAttempt->username !!}
                        </td>
                        <td data-field="action" class="pt-0 pb-0">
                            {!! $loginAttempt->action !!}
                        </td>
                        <td data-field="ip_address" class="pt-0 pb-0">
                            {!! $loginAttempt->ip_address !!}
                        </td>
                        <td data-field="success" class="has-text-centered" class="pt-0 pb-0">
                            {{ !empty($loginAttempts->success) ? 'yes' : 'no '}}
                        </td>
                        <td data-field="created_at" class="pt-0 pb-0">
                            {{ longDateTime($loginAttempt->created_at) }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">There are no entries in
                            the {{ $type == 'admin' ? 'login_attempts_admin' : 'login_attempts_user' }} log.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $loginAttempts->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
