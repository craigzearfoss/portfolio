@extends('admin.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ],
    'selectList'    => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.framework.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons'       => [
        canCreate('framework')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'href' => route('admin.dictionary.framework.create') ]]
            : [],
    ],
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

            @forelse ($frameworks as $framework)

                <tr data-id="{{ $framework->id }}">
                    <td data-field="name">
                        {{ $framework->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $framework->abbreviation }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $framework->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $framework->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($framework))
                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.framework.show', $framework->id) }}">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        @endif

                        @if(canUpdate($framework))
                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.framework.edit', $framework->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endif

                        @if (!empty($framework->link))
                            <a title="link"
                               class="button is-small px-1 py-0"
                               href="{{ !empty($framework->link_name) ? $framework->link_name : 'link' }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @endif

                        @if (!empty($framework->wikipedia))
                            <a title="Wikipedia page"
                               class="button is-small px-1 py-0"
                               href="{{ $framework->wikipedia }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @endif

                        @if(canDelete($framework))
                            <form action="{{ route('admin.dictionary.framework.destroy', $framework->id) }}"
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
                    <td colspan="5">There are no frameworks.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $frameworks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
