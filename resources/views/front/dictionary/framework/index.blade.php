@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.framework.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'front.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'url' => route('admin.dictionary.framework.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        {!! $frameworks->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($frameworks as $framework)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $framework,
                        'route' => route('front.dictionary.framework.show', $framework->slug)
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
