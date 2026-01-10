@php
    $buttons = [];
    if (canCreate('resource', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resource', 'href' => route('admin.system.resource.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Resources',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Resources' ],
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
                <th>table</th>
                <th>icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">global</th>
                <th class="has-text-centered">sequence</th>
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
                <th>table</th>
                <th>icon</th>
                <th>sequence</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">global</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($resources as $resource)

                <tr data-id="{{ $resource->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $resource->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ htmlspecialchars($resource->name ?? '') }}
                    </td>
                    <td data-field="database.name">
                        {{ htmlspecialchars($resource->database['name'] ?? '') }}
                    </td>
                    <td data-field="table">
                        {{ $resource->table }}
                    </td>
                    <td data-field="icon">
                        @if (!empty($resource->icon))
                            <span class="text-xl">
                                <i class="fa-solid {{ $resource->icon }}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td data-field="guest" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->guest ])
                    </td>
                    <td data-field="user" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->user ])
                    </td>
                    <td data-field="admin" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->admin ])
                    </td>
                    <td data-field="admin" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->global ])
                    </td>
                    <td data-field="sequence">
                        {{ $resource->sequence }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->disabled ])
                    </td>
                    <td>
                        <form action="{{ route('admin.system.resource.destroy', $resource->id) }}" method="POST">

                            @if(canRead($resource))
                                <a class="button is-small px-1 py-0" href="{{ route('admin.system.resource.show', $resource->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($resource))
                                <a class="button is-small px-1 py-0" href="{{ route('admin.system.resource.edit', $resource->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($resource))
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
                    <td colspan="{{ isRootAdmin() ? '13' : '12' }}>There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $resources->links('vendor.pagination.bulma') !!}

    </div>

@endsection
