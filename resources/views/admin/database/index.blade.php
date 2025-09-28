@extends('admin.layouts.default', [
    'title' => 'Databases',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Databases' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.database.create') ],
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
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th>icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th>sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
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
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th>sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($databases as $database)

                <tr data-id="{{ $database->id }}">
                    <td data-field="name">
                        {{ $database->name }}
                    </td>
                    <td data-field="database">
                        {{ $database->database }}
                    </td>
                    <td> data-field="tag"
                        {{ $database->tag }}
                    </td>
                    <td data-field="title">
                        {{ $database->title }}
                    </td>
                    <td data-field="icon">
                        @if (!empty($database->icon))
                            <span class="text-xl">
                                <i class="fa-solid {{ $database->icon }}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td data-field="guest" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->guest ])
                    </td>
                    <td data-field="user" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->user ])
                    </td>
                    <td data-field="admin" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->admin ])
                    </td>
                    <td data-field="sequence">
                        {{ $database->sequence }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->disabled ])
                    </td>
                    <td>
                        <form action="{{ route('admin.database.destroy', $database->id) }}" method="POST">

                            <a class="button is-small px-1 py-0" href="{{ route('admin.database.show', $database->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a class="button is-small px-1 py-0" href="{{ route('admin.database.edit', $database->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="12">There are no databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
