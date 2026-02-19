@php
    use App\Enums\EnvTypes;
    use App\Enums\PermissionEntityTypes;
    use App\Models\Dictionary\DictionarySection;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'stack', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Stack', 'href' => route('admin.dictionary.stack.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary (stacks)',
    'breadcrumbs'      => $breadcrumbs,
    'selectList'       => View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.stack.index'),
        'list'     => new DictionarySection()->listOptions([], 'route', 'name', true, false, [ 'name'=>'asc' ], EnvTypes::ADMIN),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]),
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'           => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $stacks->links('vendor.pagination.bulma') !!}
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

            @forelse ($stacks as $stack)

                <tr data-id="{{ $stack->id }}">
                    <td data-field="name">
                        {!! $stack->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $stack->abbreviation !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $stack->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $stack->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(PermissionEntityTypes::RESOURCE, $server, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.dictionary.stack.show', $stack),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(PermissionEntityTypes::RESOURCE, $stack, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.dictionary.stack.edit', $stack),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($stack->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($stack->link_name) ? $stack->link_name : 'link',
                                    'href'   => $stack->link,
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

                            @if (!empty($stack->wikipedia))
                                @include('admin.components.link-icon', [
                                    'title'  => 'Wikipedia page',
                                    'href'   => $stack->wikipedia,
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

                            @if(canDelete(PermissionEntityTypes::RESOURCE, $stack, $admin))
                                <form class="delete-resource"
                                      action="{!! route('admin.dictionary.stack.destroy', $stack) !!}" method="POST">
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
                    <td colspan="5">There are no stacks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $stacks->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
