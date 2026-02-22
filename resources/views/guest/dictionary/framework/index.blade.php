@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary: Frameworks';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ];

    // set navigation buttons
    $buttons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.framework.index'),
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

        {!! $frameworks->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($frameworks as $framework)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $framework,
                        'route' => route('guest.dictionary.framework.show', $framework->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no frameworks in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $frameworks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
