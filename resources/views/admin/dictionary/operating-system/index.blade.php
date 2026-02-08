@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'operating-system', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Operating System', 'href' => route('admin.dictionary.operating-system.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary (operating systems)',
    'breadcrumbs'      => $breadcrumbs,
    'selectList'       => View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.operating-system.index'),
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
            {!! $operatingSystems->links('vendor.pagination.bulma') !!}
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

            @forelse ($operatingSystems as $operatingSystem)

                <tr data-id="{{ $operatingSystem->id }}">
                    <td data-field="name">
                        {!! $operatingSystem->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $operatingSystem->abbreviation !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $operatingSystem, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.dictionary.operating-system.show', $operatingSystem),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $operatingSystem), $admin)
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.dictionary.operating-system.edit', $operatingSystem),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($operatingSystem->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($operatingSystem->link_name) ? $operatingSystem->link_name : 'link',
                                    'href'   => $operatingSystem->link,
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

                            @if (!empty($operatingSystem->wikipedia))
                                @include('admin.components.link-icon', [
                                    'title'  => 'Wikipedia page',
                                    'href'   => $operatingSystem->wikipedia,
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $operatingSystem, $admin))
                                <form class="delete-resource" action="{!! route('admin.dictionary.operating-system.destroy', $operatingSystem) !!}" method="POST">
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
                    <td colspan="5">There are no operating systems.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $operatingSystems->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
