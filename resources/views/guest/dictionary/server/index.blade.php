@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Servers' ]
    ];

    // set navigation buttons
    $navButtons = [];

    $navSelectList = view('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.server.index'),
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
                {!! $servers->links('vendor.pagination.bulma') !!}
            @endif

            <ul class="dictionary-list">

                @forelse ($servers as $server)

                    <li>
                        @include('guest.components.dictionary-definition', [
                            'word'  => $server,
                            'route' => route('guest.dictionary.server.show', $server->slug)
                        ])
                    </li>

                @empty

                    <tr>
                        <li>There are no servers in the dictionary.</li>
                    </tr>

                @endforelse

            </ul>

            @if(!empty($pagination_bottom))
                {!! $servers->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
