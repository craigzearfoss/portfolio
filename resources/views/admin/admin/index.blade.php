@extends('admin.layouts.default', [
    'title' => 'Admins',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'href' => route('admin.admin.create') ],
        [ 'name' => '<i class="fa fa-list"></i> Admin Teams',   'href' => route('admin.admin-team.index') ],
        [ 'name' => '<i class="fa fa-list"></i> Admin Groups',  'href' => route('admin.admin-group.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th style="white-space: nowrap;">user name</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th style="white-space: nowrap;">user name</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
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
                    <td data-field="username">
                        {{ $admin->username }}
                    </td>
                    <td data-field="name">
                        {{ $admin->name }}
                    </td>
                    <td data-field="email">
                        {{ $admin->email }}
                    </td>
                    <td data-field="phone">
                        {{ $admin->phone }}
                    </td>
                    <td data-field="phone">
                        {{ \App\Models\User::statusName($admin->status) }}
                    </td>
                    <td data-field="root" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->root ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.show', $admin->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            @if (!empty($admin->link))
                                <a title="{{ !empty($admin->link_name) ? $admin->$project : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $admin->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.edit', $admin->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
