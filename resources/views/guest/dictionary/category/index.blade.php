@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Categories' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.category.index'),
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
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        {!! $categories->links('vendor.pagination.bulma') !!}

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

        {!! $categories->links('vendor.pagination.bulma') !!}

    </div>

@endsection
