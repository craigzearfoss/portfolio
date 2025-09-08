@extends('admin.layouts.default', [
    'title' => 'Databases',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Databases' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.database.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th>icon</th>
                <th class="text-center">guest</th>
                <th class="text-center">user</th>
                <th class="text-center">admin</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th>icon</th>
                <th class="text-center">guest</th>
                <th class="text-center">user</th>
                <th class="text-center">admin</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($databases as $database)

                <tr>
                    <td class="py-0">
                        {{ $database->name }}
                    </td>
                    <td class="py-0">
                        {{ $database->database }}
                    </td>
                    <td class="py-0">
                        {{ $database->tag }}
                    </td>
                    <td class="py-0">
                        {{ $database->title }}
                    </td>
                    <td class="py-0">
                        @if (!empty($database->icon))
                            <span class="text-xl">
                                <i class="fa-solid {{ $database->icon }}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->guest ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->user ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->admin ])
                    </td>
                    <td class="py-0 text-center">
                        {{ $database->sequence }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->readonly ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->root ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->disabled ])
                    </td>
                    <td class="py-0 text-nowrap">
                        <form action="{{ route('admin.database.destroy', $database->id) }}" method="POST">

                            <a class="button is-small px-1 py-0" href="{{ route('admin.database.show', $database->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a class="button is-small px-1 py-0" href="{{ route('admin.database.edit', $database->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="14">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
