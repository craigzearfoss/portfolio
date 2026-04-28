@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Languages' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList = view('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.language.index'),
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

            @if(!empty($pagination_top))
                {!! $languages->links('vendor.pagination.bulma') !!}
            @endif

            <ul class="dictionary-list">

                @forelse ($languages as $language)

                    <li>
                        @include('guest.components.dictionary-definition', [
                            'word'  => $language,
                            'route' => route('guest.dictionary.language.show', $language->slug)
                        ])
                    </li>

                @empty

                    <tr>
                        <li>There are no languages in the dictionary.</li>
                    </tr>

                @endforelse

            </ul>

            @if(!empty($pagination_bottom))
                {!! $languages->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
