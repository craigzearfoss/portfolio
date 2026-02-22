@php
    use App\Models\Dictionary\DictionarySection;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Dictionary' ]
    ];

    // set navigation buttons
    $buttons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => '',
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

    <div style="display: flex;">

        <div class="card p-4">
            <ul>

                @forelse ($words as $word)

                    <li>
                        @include('guest.components.dictionary-definition', [
                            'word'  => $word,
                            'route' => route('guest.dictionary.'.$word->table_slug.'.show', $word->slug)
                        ])
                    </li>

                @empty

                    <tr>
                        <li>There are no words in the dictionary.</li>
                    </tr>

                @endforelse

            </ul>

            {!! $words->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
