@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Dictionary']
    ],
    'selectList' => View::make('  admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        {!! $words->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($words as $word)

                <li>
                    @include('admin.components.dictionary-definition', [
                        'word'  => $word,
                        'route' => route('admin.dictionary.'.$word->table_slug.'.show', $word->id)
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
