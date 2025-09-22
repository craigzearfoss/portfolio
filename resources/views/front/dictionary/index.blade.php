@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'url' => route('front.homepage')],
        [ 'name' => 'Dictionary']
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => '',
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'front.'),
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

        <ul>

            @forelse ($words as $word)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $word,
                        'route' => route('front.dictionary.'.$word->table_slug.'.show', $word->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no words in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $words->links('vendor.pagination.bulma') !!}

    </div>

@endsection
