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

    <?php /*
    <div>

        <div class="card m-4">

            <div class="card-head p-4">
                <h1>Dictionaries</h1>
            </div>

            <div class="card-body p-4">

                <ul>
                    @foreach ($dictionaryTypes as $dictionaryType)
                        <li><a href="{{ route('admin.dictionary.'.$dictionaryType->type.'.index') }}">{{ $dictionaryType->name }}</a></li>
                    @endforeach
                </ul>

            </div>

        </div>

    </div>
 */ ?>


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


@endsection
