@extends('guest.layouts.default', [
    'title' => 'Portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
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
                    @include('guest.components.link', [
                        'name'  => $resource['plural'],
                        'href'  => route('guest.' . $resource['database_database'] . '.' . $resource['name'] . '.index'),
                        'title' => $resource['title'] ?? '',
                        'icon'  => 'fa-pen-to-square'
                    ])
                </li>
            @endforeach
        </ul>

    </div>

@endsection
