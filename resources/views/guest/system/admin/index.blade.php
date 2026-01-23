@php @endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Users',
    'breadcrumbs'      => [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Users']
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
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

            @forelse ($owners as $owner)

                <tr data-id="{{ $owner->id }}">
                    <td data-field="thumbnail" style="width: 32px;">
                        @if(!empty($owner->thumbnail))
                            @include('guest.components.link', [
                                'name' => view('guest.components.image', [
                                                'src'      => $owner->thumbnail,
                                                'alt'      => 'profile image',
                                                'width'    => '30px',
                                                'filename' => $owner->thumbnail
                                            ]),
                                'href' => route('guest.admin.show', $owner),
                            ])
                        @endif
                    </td>
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name' => !empty($owner->name) ? $owner->name : $owner->label,
                            'href' => route('guest.admin.show', $owner),
                        ])
                    </td>
                    <td data-field="role">
                        {!! $owner->role !!}
                    </td>
                    <td data-field="employer">
                        {!! $owner->employer !!}
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $owners->links('vendor.pagination.bulma') !!}

    </div>

@endsection
