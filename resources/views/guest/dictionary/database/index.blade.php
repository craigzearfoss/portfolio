@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary: Databases';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.database.index'),
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

        {!! $databases->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($databases as $database)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $database,
                        'route' => route('guest.dictionary.database.show', $database->slug),
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no databases in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
