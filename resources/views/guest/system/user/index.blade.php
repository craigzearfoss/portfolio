@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Users']
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Users',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
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

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th></th>
                    <th>name</th>
                    <th>role</th>
                    <th>employer</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th style="white-space: nowrap;">user name</th>
                    <th>name</th>
                    <th>team</th>
                    <th>email</th>
                    <th>status</th>
                    <th class="has-text-centered">root</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($users as $user)

                    <tr data-id="{{ $user->id }}">
                        <td data-field="thumbnail" style="width: 32px;">
                            @if(!empty($user->thumbnail))
                                @include('guest.components.link', [
                                    'name' => view('guest.components.image', [
                                                    'src'      => $user->thumbnail,
                                                    'alt'      => 'profile image',
                                                    'width'    => '30px',
                                                    'filename' => $user->thumbnail
                                                ]),
                                    'href' => route('guest..$user.show', $user),
                                ])
                            @endif
                        </td>
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name' => !empty($user->name) ? $user->name : $user->label,
                                'href' => route('guest.user.show', $user),
                            ])
                        </td>
                        <td data-field="role">
                            {!! $user->role !!}
                        </td>
                        <td data-field="employer">
                            {!! $user->employer !!}
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">There are no users.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $users->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
