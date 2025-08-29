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

@endsection
