@php
    use App\Models\Dictionary\DictionarySection;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => 'Dictionary: Operating Systems' ,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'selectList'       => View::make('guest.components.form-select', [
                            'name'     => '',
                            'label'    => '',
                            'value'    => route('guest.dictionary.operating-system.index'),
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

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

        <ul>

            @forelse ($operatingSystems as $operatingSystem)

                <li>
                    @include('guest.components.dictionary-definition', [
                        'word'  => $operatingSystem,
                        'route' => route('guest.dictionary.operating-system.show', $operatingSystem->slug)
                    ])
                </li>

            @empty

                <tr>
                    <li>There are no operating systems in the dictionary.</li>
                </tr>

            @endforelse

        </ul>

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

    </div>

@endsection
