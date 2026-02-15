@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Frameworks' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.framework.index'),
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

        {!! $frameworks->links('vendor.pagination.bulma') !!}

        <ul>

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

        {!! $frameworks->links('vendor.pagination.bulma') !!}

    </div>

@endsection
