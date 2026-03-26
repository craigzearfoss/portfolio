@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.category.index'),
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
                {!! $categories->links('vendor.pagination.bulma') !!}
            @endif

            <ul>

                @forelse ($categories as $category)

                    <li>
                        @include('guest.components.dictionary-definition', [
                            'word'  => $category,
                            'route' => route('guest.dictionary.category.show', $category->slug)
                        ])
                    </li>

                @empty

                    <tr>
                        <li>There are no categories in the dictionary.</li>
                    </tr>

                @endforelse

            </ul>

            @if($pagination_bottom)
                {!! $categories->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
