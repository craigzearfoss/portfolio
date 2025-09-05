@extends('admin.layouts.default', [
    'title' => 'Resources',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Resources' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resource', 'url' => route('admin.resource.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>type</th>
                <th>name</th>
                <th>icon</th>
                <th>section</th>
                <th>database</th>
                <th class="text-center">front</th>
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
                <th>type</th>
                <th>name</th>
                <th>database</th>
                <th>icon</th>
                <th>sequence</th>
                <th class="text-center">front</th>
                <th class="text-center">user</th>
                <th class="text-center">admin</th>
                <th class="text-center">public</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($resources as $resource)

                <tr>
                    <td class="py-0">
                        {{ $resource->type }}
                    </td>
                    <td class="py-0">
                        {{ $resource->name }}
                    </td>
                    <td class="py-0">
                        @if (!empty($resource->icon))
                            <span class="text-xl">
                                <i class="fa-solid {{ $resource->icon }}"></i>
                            </span>
                        @else
                        @endif
                    </td>
                    <td class="py-0">
                        {{ $resource->section }}
                    </td>
                    <td class="py-0">
                        {{ $resource->database['name'] }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->front ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->user ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->admin ])
                    </td>
                    <td class="py-0 text-center">
                        {{ $resource->sequence }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->readonly ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->root ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $resource->disabled ])
                    </td>
                    <td class="py-0 text-nowrap">
                        <form action="{{ route('admin.resource.destroy', $resource->id) }}" method="POST">

                            <a class="button is-small px-1 py-0" href="{{ route('admin.resource.show', $resource->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a class="button is-small px-1 py-0" href="{{ route('admin.resource.edit', $resource->id) }}">
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

        {!! $resources->links('vendor.pagination.bulma') !!}

    </div>

@endsection
