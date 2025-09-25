@extends('admin.layouts.default', [
    'title' => 'Resources',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Resources' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resource', 'url' => route('admin.resource.create') ],
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
                <th>table</th>
                <th>title</th>
                <th>icon</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>database</th>
                <th>table</th>
                <th>title</th>
                <th>icon</th>
                <th>sequence</th>
                <th class="has-text-centered">guest</th>
                <th class="has-text-centered">user</th>
                <th class="has-text-centered">admin</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($resources as $resource)

                <tr>
                    <td class="py-0">
                        {{ $resource->name }}
                    </td>
                    <td class="py-0">
                        {{ $resource->database['name'] }}
                    </td>
                    <td class="py-0">
                        {{ $resource->table }}
                    </td>
                    <td class="py-0">
                        @if (!empty($resource->icon))
                            <span class="text-xl">
                                <i class="fa-solid {{ $resource->icon }}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->guest ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->user ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->admin ])
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $resource->sequence }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resource->disabled ])
                    </td>
                    <td class="py-0 text-nowrap">
                        <form action="{{ route('admin.resource.destroy', $resource->id) }}" method="POST">

                            <a class="button is-small px-1 py-0" href="{{ route('admin.resource.show', $resource->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a class="button is-small px-1 py-0" href="{{ route('admin.resource.edit', $resource->id) }}">
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
                    <td colspan="12">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $resources->links('vendor.pagination.bulma') !!}

    </div>

@endsection
