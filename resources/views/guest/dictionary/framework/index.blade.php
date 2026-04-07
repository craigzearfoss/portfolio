@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.framework.index'),
        'list'     => new DictionarySection()->listOptions(
                          [],
                          'route',
                          'plural',
                          true
                      ),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]);
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $frameworks->links('vendor.pagination.bulma') !!}
            @endif

            <ul class="dictionary-list">

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

            @if($pagination_bottom)
                {!! $frameworks->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
