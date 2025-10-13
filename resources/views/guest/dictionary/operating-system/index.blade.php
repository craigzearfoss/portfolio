@extends('guest.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ],
    'selectList' => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('guest.dictionary.operating-system.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

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
