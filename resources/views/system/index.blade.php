@php /* for url '/' */ @endphp
@extends('guest.layouts.default', [
    'title'   => config('app.name'),
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column p-4">

        <div class="column has-text-centered">

            <h1 class="title">{{ config('app.name') }}</h1>

            <div class="has-text-centered">
                <a class="is-size-6" href="{{ route('user.login') }}">
                    User Login
                </a>
                |
                <a class="is-size-6" href="{{ route('admin.login') }}">
                    Admin Login
                </a>
            </div>

        </div>

    </div>

    <div class="card p-4">

        <h4 class="title is-size-4">Users</h4>
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

            @forelse ($admins as $thisAdmin)

                <tr data-id="{{ $thisAdmin->id }}">
                    <td data-field="thumbnail" style="width: 40px;">
                        @if(!empty($thisAdmin->thumbnail))
                            @include('guest.components.link', [
                                'name' => view('guest.components.image', [
                                                'src'      => $thisAdmin->thumbnail,
                                                'alt'      => 'profile image',
                                                'width'    => '40px',
                                                'filename' => $thisAdmin->thumbnail
                                            ]),
                                'href' => route('guest.admin.show', $thisAdmin),
                            ])
                        @endif
                    </td>
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name' => !empty($thisAdmin->name) ? $thisAdmin->name : $thisAdmin->username,
                            'href' => route('guest.admin.show', $thisAdmin),
                        ])
                    </td>
                    <td data-field="role">
                        {{ $thisAdmin->role ?? '' }}
                    </td>
                    <td data-field="employer">
                        {{ $thisAdmin->employer ?? '' }}
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
