@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('front.dictionary.index') ],
        [ 'name' => 'Libraries' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.library.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'front.'),
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

        {!! $libraries->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($libraries as $library)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $library,
                        'route' => route('front.dictionary.library.show', $library->slug)
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
