@extends('admin.layouts.default', [
    'pageTitle' => ucfirst($envType) . ' Menu',
    'title'     => view('admin.components.form-select-nolabel', [
                    'name'  => '',
                    'id'    => 'env_type',
                    'value' => route('admin.system.menu-item.index', $envType),
                    'list'  => [
                                    route('admin.system.menu-item.index', 'admin') => 'Admin',
                                    route('admin.system.menu-item.index', 'user')  => 'User',
                                    route('admin.system.menu-item.index', 'guest') => 'Guest',
                               ],

                    'class' => 'subtitle is-bold',
                    'style' => 'display: inline-block; font-weight: 700;',
                    'onchange' => "window.location.href = document.getElementById('env_type').value"
                ]) . ' Menu',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => ucfirst($envType) .  ' Menu' ],
    ],
    'buttons' => [
        /*
        [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.menu-item.create') ],
        */
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>parent</th>
                <th style="white-space: nowrap;">database->resource</th>
                <th style="white-space: nowrap;">route</th>
                <th style="white-space: nowrap;">name</th>
                <th>icon</th>
                <th>sequence</th>
                <th>public</th>
                <th>disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>parent</th>
                <th style="white-space: nowrap;">database->resource</th>
                <th style="white-space: nowrap;">route</th>
                <th style="white-space: nowrap;">name</th>
                <th>icon</th>
                <th>sequence</th>
                <th>public</th>
                <th>disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($menuItems as $menuItem)

                <tr data-id="{{ $menuItem->id }}">
                    <td data-field="parent" class="has-text-centered">
                        @if(!empty($menuItem['parent_id']))
                            @include('admin.components.link', [
                                'name' => view('admin.components.icon', [ 'icon' => 'fa-arrow-left' ]),
                                'href' => ''
                            ])

                        @endif
                    </td>
                    <td data-field="database_id|resource_id" style="white-space: nowrap;">
                        @php
                            $parts = [];
                            if (!empty($menuItem->database['name'])) $parts[] = $menuItem->database['name'];
                            if (!empty($menuItem->resource['name'])) $parts[] = $menuItem->resource['name'];
                        @endphp
                        {{ implode('->', $parts) }}
                    </td>
                    <td data-field="route" style="white-space: nowrap;">
                        {{ $menuItem->route }}
                    </td>
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $menuItem->name }}
                    </td>
                    <td data-field="icon">
                        @if (!empty($menuItem->icon))
                            @include('admin.components.icon', [ 'icon' => $menuItem->icon ])
                        @endif
                    </td>
                    <td data-field="sequence" class="has-text-right">
                        {{ $menuItem->sequence }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $menuItem->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $menuItem->disabled ])
                    </td>

                    <td style="white-space: nowrap;">

                        <?php /*
                        <a class="btn btn-sm" href="{{ route('admin.system.menu-item.show', $menuItem->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- show --}}
                        </a>

                        <?php /*
                        <a class="btn btn-sm" href="{{ route('admin.system.menu-item.edit', $menuItem->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- edit--}}
                        </a>
                        * / ?>

                        <form action="{{ route('admin.system.menu-item.destroy', $menuItem->id) }}"
                              method="POST"
                              style="display: inline-block;"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm">
                                <i class="fa-solid fa-trash"></i>{{-- delete--}}
                            </button>
                        </form>
                        */ ?>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="9">There are no menu items.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

    </div>

@endsection
