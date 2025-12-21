@extends('guest.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home', 'href' => route('system.index')],
        [ 'name' => 'Dictionary']
    ],
    'selectList'    => View::make('guest.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => '',
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
    'admin'         => null,
])

@section('content')

    <div class="card p-4">

        <ul>

            @forelse ($words as $word)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $word,
                        'route' => route('guest.dictionary.'.$word->table_slug.'.show', $word->slug)
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

@endsection
