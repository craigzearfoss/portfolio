@extends('admin.layouts.default', [
    'title' => 'Admins',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Admins']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin', 'url' => route('admin.admin.create') ],
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
                <th class="whitespace-nowrap">user name</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th class="whitespace-nowrap">user name</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
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
                    <td data-field="root" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->root ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.show', $admin->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            @if (!empty($admin->link))
                                <a title="{{ !empty($admin->link_name) ? $admin->$project : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $admin->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.edit', $admin->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">There are no admins.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
