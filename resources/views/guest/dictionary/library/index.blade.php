@extends('guest.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries' ]
    ],
    'selectList' => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('guest.dictionary.library.index'),
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

        {!! $libraries->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($libraries as $library)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $library,
                        'route' => route('guest.dictionary.library.show', $library->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no libraries in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $libraries->links('vendor.pagination.bulma') !!}

    </div>

@endsection
