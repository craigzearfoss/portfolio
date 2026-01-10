@extends('guest.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Languages' ]
    ],
    'selectList'    => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.language.index'),
                            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'guest.'),
                            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
                            'message'  => $message ?? '',
                        ]),
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    <div class="card p-4">

        {!! $languages->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($languages as $language)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => htmlspecialchars($language ?? ''),
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
