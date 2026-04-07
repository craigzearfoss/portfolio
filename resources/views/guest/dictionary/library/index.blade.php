@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList= View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.library.index'),
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
                {!! $libraries->links('vendor.pagination.bulma') !!}
            @endif

            <ul class="dictionary-list">

                @forelse ($libraries as $library)

                    <li>
                        @include('guest.components.dictionary-definition', [
                            'word'  => $library,
                            'route' => route('guest.dictionary.library.show', $library->slug)
                        ])
                    </li>

                @empty

                    <tr>
                        <li>There are no libraries in the dictionary.</li>
                    </tr>

                @endforelse

            </ul>

            @if($pagination_bottom)
                {!! $libraries->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
