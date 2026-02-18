@php
    use App\Models\Dictionary\DictionarySection;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Languages' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Languages' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.language.index'),
                            'list'     => new DictionarySection()->listOptions(
                                [],
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

        {!! $languages->links('vendor.pagination.bulma') !!}

        <ul>

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

        {!! $languages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
