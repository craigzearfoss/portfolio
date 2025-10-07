@extends('guest.layouts.default', [
    'title' => 'Portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio']
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="list is-hoverable">

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($portfolios as $portfolio)

                        <li>
                            @include('guest.components.link', [
                                'name'  => $portfolio->plural,
                                'href'  => route('guest.portfolio.'.$portfolio->name.'.index'),
                                'class' => 'list-item',
                            ])
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

</div>

@endsection
