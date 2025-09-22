@extends('front.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'url' => route('front.homepage') ],
        [ 'name' => 'Dictionary', 'url' => route('front.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ],
    'selectList' => View::make('front.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('front.dictionary.operating-system.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'front.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($operatingSystems as $operatingSystem)

                <li>
                    @include('front.components.dictionary-definition', [
                        'word'  => $operatingSystem,
                        'route' => route('front.dictionary.operating-system.show', $operatingSystem->slug)
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
