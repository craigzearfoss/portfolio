@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks' ],
    ],
    'selectList' => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.stack.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Stack', 'url' => route('admin.dictionary.stack.create') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($stacks as $stack)

                <tr>
                    <td class="py-0">
                        {{ $stack->name }}
                    </td>
                    <td class="py-0">
                        {{ $stack->abbreviation }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $stack->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $stack->readonly ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $stack->root ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $stack->disabled ])
                    </td>
                    <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.dictionary.stack.destroy', $stack->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.stack.show', $stack->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.stack.edit', $stack->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($stack->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $stack->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @if (!empty($stack->wikipedia))
                                <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $stack->wikipedia }}"
                                   target="_blank">
                                    <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
                                </a>
                            @else
                                <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">There are no stacks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $stacks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
