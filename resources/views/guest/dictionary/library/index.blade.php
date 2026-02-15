@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Libraries' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.library.index'),
                            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([],
                                                                                                'route',
                                                                                                'name',
                                                                                                true
                                                                                               ),
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

        {!! $libraries->links('vendor.pagination.bulma') !!}

        <ul>

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

        {!! $libraries->links('vendor.pagination.bulma') !!}

    </div>

@endsection
