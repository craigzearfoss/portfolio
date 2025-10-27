@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? 'Users',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users']
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
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

            @forelse ($admins as $admin)

                <tr data-id="{{ $admin->id }}">
                    <td data-field="thumbnail" style="width: 32px;">
                        @if(!empty($admin->thumbnail))
                            @include('guest.components.link', [
                                'name' => view('guest.components.image', [
                                                'src'      => $admin->thumbnail,
                                                'alt'      => 'profile image',
                                                'width'    => '30px',
                                                'filename' => $admin->thumbnail
                                            ]),
                                'href' => route('guest.admin.show', $admin),
                            ])
                        @endif
                    </td>
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name' => !empty($admin->name) ? $admin->name : $admin->username,
                            'href' => route('guest.admin.show', $admin),
                        ])
                    </td>
                    <td data-field="role">
                        {{ $admin->role ?? '' }}
                    </td>
                    <td data-field="employer">
                        {{ $admin->employer ?? '' }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no users.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
