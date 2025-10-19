@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' personal',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => $title ?? 'Personal' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
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
                                'href'  => route('guest.user.personal.'.$personal->name.'.index', $admin),
                                'class' => 'list-item',
                            ])
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

</div>

@endsection
