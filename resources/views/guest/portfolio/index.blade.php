@extends('guest.layouts.default', [
    'title' => $title ?? 'Portfolios',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
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

            <div class="container">
                <div class="content">

                    <h3 class="title">
                        {{ $admin->name }} Portfolio
                    </h3>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($portfolioResources as $resource)

                            @if(empty($resource['global']) && Route::has('guest.admin.portfolio.'.$resource['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resource['plural'],
                                        'href'  => route('guest.admin.portfolio.'.$resource['name'].'.index', $admin),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>

        </div>

    </div>

@endsection
