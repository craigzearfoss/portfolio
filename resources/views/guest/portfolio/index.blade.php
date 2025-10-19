@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => $title ?? 'Portfolio' ],
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

                    @foreach ($portfolios as $portfolio)

                        <li>
                            @if($portfolio->name != 'job')
                                @include('guest.components.link', [
                                    'name'  => $portfolio->plural,
                                    'href'  => route('guest.user.portfolio.'.$portfolio->name.'.index', $admin),
                                    'class' => 'list-item',
                                ])
                            @endif
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

</div>

@endsection
