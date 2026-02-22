@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary: Operating Systems';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ];

    // set navigation buttons
    $buttons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.operating-system.index'),
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

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($operatingSystems as $operatingSystem)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $operatingSystem,
                        'route' => route('guest.dictionary.operating-system.show', $operatingSystem->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no operating systems in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

    </div>

@endsection
