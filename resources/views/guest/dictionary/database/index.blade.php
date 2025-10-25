@extends('guest.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ],
    'selectList' => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('guest.dictionary.database.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        {!! $databases->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($databases as $database)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $database,
                        'route' => route('guest.dictionary.database.show', $database->slug),
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no databases in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
