@php
    use App\Enums\EnvTypes;
    use App\Models\Dictionary\DictionarySection;

    $title    = 'Dictionary';
    $subtitle = $title;

    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Dictionary']
    ];

    $navButtons = [];

    $navSelectList = View::make('admin.components.form-select', [
        'name'     => '',
        'label'    => '',
        'value'    => route('admin.dictionary.index'),
        'list'     => new DictionarySection()->listOptions([], 'route', 'name', true, false, [ 'name'=>'asc' ], EnvTypes::ADMIN),
        'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
        'message'  => $message ?? '',
    ]);
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            {!! $words->links('vendor.pagination.bulma') !!}

            <ul>

                @forelse ($words as $word)

                    <li>
                        @include('admin.components.dictionary-definition', [
                            'word'  => $word,
                            'route' => route('admin.dictionary.'.$word->table_slug.'.show', $word->id)
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
