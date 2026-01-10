@php
    $buttons = [];
    if (canCreate('operating-system', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Operating System', 'href' => route('admin.dictionary.operating-system.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ],
    'selectList'    => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.operating-system.index'),
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

            @forelse ($operatingSystems as $operatingSystem)

                <tr data-id="{{ $operatingSystem->id }}">
                    <td data-field="name">
                        {{ htmlspecialchars($operatingSystem->name ?? '') }}
                    </td>
                    <td data-field="abbreviation">
                        {{ htmlspecialchars($operatingSystem->abbreviation ?? '') }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($operatingSystem))
                            @include('admin.components.link-icon', [
                                'title' => 'show',
                                'href'  => route('admin.dictionary.operating-system.show', $operatingSystem->id),
                                'icon'  => 'fa-list'
                            ])
                        @endif

                        @if(canUpdate($operatingSystem))
                            @include('admin.components.link-icon', [
                                'title' => 'edit',
                                'href'  => route('admin.dictionary.operating-system.edit', $operatingSystem->id),
                                'icon'  => 'fa-pen-to-square'
                            ])
                        @endif

                        @if (!empty($operatingSystem->link))
                            @include('admin.components.link-icon', [
                                'title'  => htmlspecialchars((!empty($operatingSystem->link_name) ? $operatingSystem->link_name : 'link') ?? ''),
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

                        @if(canDelete($operatingSystem))
                            @csrf
                            @method('DELETE')
                            @include('admin.components.button-icon', [
                                'title' => 'delete',
                                'class' => 'delete-btn',
                                'icon'  => 'fa-trash'
                            ])
                        @endif

                        @if(canDelete($operatingSystem))

                            <form action="{{ route('admin.dictionary.operating-system.destroy', $operatingSystem->id) }}"
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
                    <td colspan="5">There are no operating systems.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

    </div>

@endsection
