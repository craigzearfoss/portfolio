@extends('guest.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Stacks' ],
    ],
    'selectList' => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('guest.dictionary.stack.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        {!! $stacks->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($stacks as $stack)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $stack,
                        'route' => route('guest.dictionary.stack.show', $stack->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no stacks in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $stacks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
