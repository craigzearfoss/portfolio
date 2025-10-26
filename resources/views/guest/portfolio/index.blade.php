@extends('guest.layouts.default', [
    'title' => $title ?? 'Portfolios',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => $title ?? 'Portfolios' ],
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
                    <p>
                        Portfolios folders contain work and job-related items and accomplishments. They include:
                    </p>
                    <ul class="menu-list" style="max-width: 20em;">

                        @foreach ($portfolios as $portfolio)

                            <li>{{ $portfolio->plural }}</li>

                        @endforeach

                    </ul>
                </div>
            </div>

        </div>

</div>

@endsection
