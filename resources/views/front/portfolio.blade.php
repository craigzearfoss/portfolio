@extends('front.layouts.default', [
    'title' => 'Portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'url' => route('front.index') ],
        [ 'Portfolio' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <h2 class="subtitle">Portfolio</h2>

        <ul>
            @foreach($resources as $resource)
                <li class="list-item">
                    @include('front.components.link', [
                        'name'  => $resource['plural'],
                        'url'   => route('front.' . $resource['database_database'] . '.' . $resource['name'] . '.index'),
                        'title' => $resource['title'] ?? '',
                        'icon'  => 'fa-pen-to-square'
                    ])
                </li>
            @endforeach
        </ul>

    </div>

@endsection
