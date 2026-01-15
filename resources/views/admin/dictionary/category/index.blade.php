@php
    $buttons = [];
    if (canCreate('category', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Category', 'href' => route('admin.dictionary.category.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => 'Dictionary (categories)',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ],
    'selectList'       => View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.category.index'),
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

            @forelse ($categories as $category)

                <tr data-id="{{ $category->id }}">
                    <td data-field="name">
                        {!! $category->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $category->abbreviation !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($category))
                            @include('admin.components.link-icon', [
                                'title' => 'show',
                                'href'  => route('admin.dictionary.category.show', $category->id),
                                'icon'  => 'fa-list'
                            ])
                        @endif

                        @if(canUpdate($category))
                            @include('admin.components.link-icon', [
                                'title' => 'edit',
                                'href'  => route('admin.dictionary.category.edit', $category->id),
                                'icon'  => 'fa-pen-to-square'
                            ])
                        @endif

                        @if (!empty($category->link))
                            @include('admin.components.link-icon', [
                                'title'  => !empty($category->link_name) ? $category->link_name : 'link',
                                'href'   => $category->link,
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

                        @if (!empty($category->wikipedia))
                            @include('admin.components.link-icon', [
                                'title'  => 'Wikipedia page',
                                'href'   => $category->wikipedia,
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

                        @if(canDelete($category))

                            <form action="{!! route('admin.dictionary.category.destroy', $category->id) !!}"
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
                    <td colspan="5">There are no categories.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $categories->links('vendor.pagination.bulma') !!}

    </div>

@endsection
