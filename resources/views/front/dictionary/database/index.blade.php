@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.database.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'front.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        {!! $databases->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($databases as $database)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $database,
                        'route' => route('front.dictionary.database.show', $database->slug),
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
