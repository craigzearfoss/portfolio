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
                <th class="px-2 whitespace-nowrap">user name</th>
                <th class="px-2">name</th>
                <th class="px-2">email</th>
                <th class="px-2">phone</th>
                <th class="px-2 has-text-centered">root</th>
                <th class="px-2 has-text-centered">disabled</th>
                <th class="px-2">actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th class="px-2 whitespace-nowrap">user name</th>
                <th class="px-2">name</th>
                <th class="px-2">email</th>
                <th class="px-2">phone</th>
                <th class="px-2 has-text-centered">root</th>
                <th class="px-2 has-text-centered">disabled</th>
                <th class="px-2">actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($admins as $admin)

                <tr>
                    <td class="py-0">
                        {{ $admin->username }}
                    </td>
                    <td class="py-0">
                        {{ $admin->name }}
                    </td>
                    <td class="py-0">
                        {{ $admin->email }}
                    </td>
                    <td class="py-0">
                        {{ $admin->phone }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $admin->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.show', $admin->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin.edit', $admin->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no user stacks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
