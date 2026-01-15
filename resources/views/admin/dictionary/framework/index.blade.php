@php
    $buttons = [];
    if (canCreate('framework', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'href' => route('admin.dictionary.framework.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary (frameworks)',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ],
    'selectList'       => View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.framework.index'),
        'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin.'),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]),
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="card p-4">

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
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($frameworks as $framework)

                <tr data-id="{{ $framework->id }}">
                    <td data-field="name">
                        {!! $framework->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $framework->abbreviation !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $framework->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $framework->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($framework))
                            @include('admin.components.link-icon', [
                                'title' => 'show',
                                'href'  => route('admin.dictionary.framework.show', $framework->id),
                                'icon'  => 'fa-list'
                            ])
                        @endif

                        @if(canUpdate($framework))
                            @include('admin.components.link-icon', [
                                'title' => 'edit',
                                'href'  => route('admin.dictionary.framework.edit', $framework->id),
                                'icon'  => 'fa-pen-to-square'
                            ])
                        @endif

                        @if (!empty($framework->link))
                            @include('admin.components.link-icon', [
                                'title'  => !empty($framework->link_name) ? $framework->link_name : 'link',
                                'href'   => $framework->link,
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

                        @if (!empty($framework->wikipedia))
                            @include('admin.components.link-icon', [
                                'title'  => 'Wikipedia page',
                                'href'   => $framework->wikipedia,
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

                        @if(canDelete($framework))

                            <form action="{!! route('admin.dictionary.framework.destroy', $framework->id) !!}"
                                  method="POST"
                                  style="display:inline-flex"
                            >
                                @csrf
                                @method('DELETE')

                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])

                            </form>

                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no frameworks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $frameworks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
