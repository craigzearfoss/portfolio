@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('front.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.category.index'),
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

        {!! $categories->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($categories as $category)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $category,
                        'route' => route('front.dictionary.category.show', $category->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no categories in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $categories->links('vendor.pagination.bulma') !!}

    </div>

@endsection
