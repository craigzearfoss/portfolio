@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Servers' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate('server', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Server', 'href' => route('admin.dictionary.server.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary (servers)',
    'breadcrumbs'      => $breadcrumbs,
    'selectList'       => View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.server.index'),
        'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin'),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]),
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $servers->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>abbrev</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($servers as $server)

                <tr data-id="{{ $server->id }}">
                    <td data-field="name">
                        {!! $server->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $server->abbreviation !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $server->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $server->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($server, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.dictionary.server.show', $server),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($server, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.dictionary.server.edit', $server),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($server->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($server->link_name) ? $server->link_name : 'link',
                                    'href'   => $server->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if (!empty($server->wikipedia))
                                @include('admin.components.link-icon', [
                                    'title'  => 'Wikipedia page',
                                    'href'   => $server->wikipedia,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete($server, $admin))
                                <form class="delete-resource" action="{!! route('admin.dictionary.server.destroy', $server) !!}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @include('admin.components.button-icon', [
                                        'title' => 'delete',
                                        'class' => 'delete-btn',
                                        'icon'  => 'fa-trash'
                                    ])
                                </form>
                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no servers.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $servers->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
