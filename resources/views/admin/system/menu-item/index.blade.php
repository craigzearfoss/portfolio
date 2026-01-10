@extends('admin.layouts.default', [
    'pageTitle'     => ucfirst($envType) . ' Menu',
    'title'         => view('admin.components.form-select-nolabel', [
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
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => ucfirst($envType) .  ' Menu' ],
    ],
    'buttons'       => [
        /*
        [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.menu-item.create') ],
        */
    ],
    'errorMessages' => $errors->any() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>level 1</th>
                <th style="white-space: nowrap;">level 2</th>
                <th style="white-space: nowrap;">route</th>
                <th>icon+name</th>
                <th>sequence</th>
                <th>public</th>
                <th>disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>level 1</th>
                <th style="white-space: nowrap;">level 2</th>
                <th style="white-space: nowrap;">route</th>
                <th>icon+/name</th>
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
                    <td data-field="parent_id" data-value="{{ $menuItem->parent_id }}" style="white-space: nowrap;">
                        @if(empty($menuItem->parent_id))
                            {{ htmlspecialchars($menuItem->name ?? '') }}
                        @else
                            {{ htmlspecialchars(\App\Models\System\MenuItem::find($menuItem->parent_id)->name ?? '') }}
                        @endif
                    </td>
                    <td data-field="resource_id" data-value="{{ $menuItem->resource_id }}" style="white-space: nowrap;">
                        @if(!empty($menuItem->parent_id))
                            {{ htmlspecialchars($menuItem->name ?? '') }}
                        @endif
                    </td>
                    <td data-field="route" data-value="{{ $menuItem->route }}" style="white-space: nowrap;">
                        {{ htmlspecialchars($menuItem->route ?? '') }}
                    </td>
                    <td data-field="icon" data-value="{{ $menuItem->icon }}">
                        @if (!empty($menuItem->icon))
                            @include('admin.components.icon', [ 'icon' => $menuItem->icon ])
                        @endif
                        {{ htmlspecialchars($menuItem->name ?? '') }}
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
                        @if(canRead($menuItem))
                            <a class="btn btn-sm" href="{{ route('admin.system.menu-item.show', $menuItem->id) }}">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        @endif

                        <?php /*
                        @if(canUpdate($menuItem))
                            <a class="btn btn-sm" href="{{ route('admin.system.menu-item.edit', $menuItem->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endif
                        * / ?>

                        <form action="{{ route('admin.system.menu-item.destroy', $menuItem->id) }}"
                              method="POST"
                              style="display: inline-block;"
                        >

                            @if(canDelete($menuItem))
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
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
