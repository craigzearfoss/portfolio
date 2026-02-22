@php
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary: Stacks';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Stacks' ]
    ];

    // set navigation buttons
    $buttons = [];

    $navSelectList = View::make('guest.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('guest.dictionary.stack.index'),
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

@extends('guest.layouts.default');

@section('content')

    <div class="card p-4">

        {!! $stacks->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($stacks as $stack)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $stack,
                        'route' => route('guest.dictionary.stack.show', $stack->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no stacks in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $stacks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
