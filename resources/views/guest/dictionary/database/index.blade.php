@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Databases' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.database.index'),
                            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest'),
                            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
                            'message'  => $message ?? '',
                        ]),
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        {!! $databases->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($databases as $database)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $word,
                        'route' => route('guest.dictionary.database.show', $database->slug),
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no databases in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
