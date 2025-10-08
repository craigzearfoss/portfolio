@extends('guest.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ],
    'selectList' => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('guest.dictionary.framework.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors'  => $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        {!! $frameworks->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($frameworks as $framework)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $framework,
                        'route' => route('guest.dictionary.framework.show', $framework->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no frameworks in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $frameworks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
