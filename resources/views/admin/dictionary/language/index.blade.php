@php
    $buttons = [];
    if (canCreate('language', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Language', 'href' => route('admin.dictionary.language.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Languages' ]
    ],
    'selectList'    => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.language.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
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

            @forelse ($languages as $language)

                <tr data-id="{{ $language->id }}">
                    <td data-field="name">
                        {{ htmlspecialchars($language->name ?? '') }}
                    </td>
                    <td data-field="abbreviation">
                        {{ htmlspecialchars($language->abbreviation ?? '') }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $language->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $language->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($language))
                            @include('admin.components.link-icon', [
                                'title' => 'show',
                                'href'  => route('admin.dictionary.language.show', $language->id),
                                'icon'  => 'fa-list'
                            ])
                        @endif

                        @if(canUpdate($language))
                            @include('admin.components.link-icon', [
                                'title' => 'edit',
                                'href'  => route('admin.dictionary.language.edit', $language->id),
                                'icon'  => 'fa-pen-to-square'
                            ])
                        @endif

                        @if (!empty($language->link))
                            @include('admin.components.link-icon', [
                                'title'  => htmlspecialchars((!empty($language->link_name) ? $language->link_name : 'link') ?? ''),
                                'href'   => $language->link,
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

                        @if (!empty($language->wikipedia))
                            @include('admin.components.link-icon', [
                                'title'  => 'Wikipedia page',
                                'href'   => $language->wikipedia,
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

                        @if(canDelete($language))

                            <form action="{{ route('admin.dictionary.language.destroy', $language->id) }}"
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
                    <td colspan="5">There are no languages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $languages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
