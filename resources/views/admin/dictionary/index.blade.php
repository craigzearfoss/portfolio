@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Dictionary']
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.form-select', [
            'name'     => '',
            'value'    => old('state') ?? '',
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true),
            'onchange' => "alert('need to implement route.');",
            'message'  => $message ?? '',
        ])

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
