@php
    $buttons = [];
    if (canCreate('database', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'href' => route('admin.system.database.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Databases',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Databases' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th>icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">global</th>
                <th>sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>database</th>
                <th>tag</th>
                <th>title</th>
                <th>icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">global</th>
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
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $database->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $database->name }}
                    </td>
                    <td data-field="database">
                        {{ $database->database }}
                    </td>
                    <td data-field="tag">
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
                    <td data-field="admin" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->global ])
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
                        <form action="{{ route('admin.system.database.destroy', $database->id) }}" method="POST">

                            @if(canRead($database))
                                <a class="button is-small px-1 py-0" href="{{ route('admin.system.database.show', $database->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($database))
                                <a class="button is-small px-1 py-0" href="{{ route('admin.system.database.edit', $database->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($database))
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '14' : '12' }}">There are no databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
