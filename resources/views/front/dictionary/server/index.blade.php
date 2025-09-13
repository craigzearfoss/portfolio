@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Servers' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.server.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'front.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        {!! $servers->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($servers as $server)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $server,
                        'route' => route('front.dictionary.server.show', $server->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no servers in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $servers->links('vendor.pagination.bulma') !!}

    </div>

@endsection
