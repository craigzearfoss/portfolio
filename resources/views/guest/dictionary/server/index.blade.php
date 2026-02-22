@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary: Servers';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Servers' ]
    ];

    // set navigation buttons
    $buttons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.server.index'),
        'list'     => new DictionarySection()->listOptions(
        [],
        'route',
        'name',
        true
        ),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]);
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="card p-4">

        {!! $servers->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($servers as $server)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $server,
                        'route' => route('guest.dictionary.server.show', $server->slug)
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
