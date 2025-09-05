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
                        <a href="{{ route('admin.dictionary.'.str_replace(' ', '-', $word->category).'.show', $word->id) }}">
                        <strong>{{ $word->name }}</strong> (<i>{{ $word->category }})</i>
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
