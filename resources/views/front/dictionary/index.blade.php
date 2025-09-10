@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('front.dashboard')],
        [ 'name' => 'Dictionary']
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('front.components.form-select', [
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
                        <a href="{{ route('front.dictionary.'.str_replace(' ', '-', $word->table_slug).'.show', $word->id) }}">
                        <strong>{{ $word->name }}</strong> (<i>{{ $word->table_name }})</i>
                        </a>
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
