@php
    $buttons = [];
    if (canCreate('stack', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Stack', 'href' => route('admin.dictionary.stack.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks' ],
    ],
    'selectList'    => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.stack.index'),
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

            @forelse ($stacks as $stack)

                <tr data-id="{{ $stack->id }}">
                    <td data-field="name">
                        {{ htmlspecialchars($stack->name ?? '') }}
                    </td>
                    <td data-field="abbreviation">
                        {{ htmlspecialchars($stack->abbreviation ?? '') }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $stack->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $stack->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($stack))
                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.stack.show', $stack->id) }}">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        @endif

                        @if(canUpdate($stack))
                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.stack.edit', $stack->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endif

                        @if (!empty($stack->link))
                            <a title="link"
                               class="button is-small px-1 py-0"
                               href="{{ htmlspecialchars((!empty($stack->link_name) ? $stack->link_name : 'link') ?? '') }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @endif

                        @if (!empty($stack->wikipedia))
                            <a title="Wikipedia page"
                               class="button is-small px-1 py-0"
                               href="{{ $stack->wikipedia }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @endif

                        @if(canDelete($stack))
                            <form action="{{ route('admin.dictionary.stack.destroy', $stack->id) }}"
                                  method="POST"
                                  style="display:inline-flex"
                            >
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no stacks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $stacks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
