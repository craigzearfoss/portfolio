@extends('guest.layouts.default', [
    'title' => 'Personal',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
        [ 'name' => 'Personal']
    ],
    'buttons' => [],
    'errors'  => $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="list is-hoverable">

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($personals as $personal)

                        <li>
                            @include('guest.components.link', [
                                'name'  => $personal->plural,
                                'href'  => route('guest.personal.'.$personal->name.'.index'),
                                'class' => 'list-item',
                            ])
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

</div>

@endsection
