@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.index', $admin) ],
    ],
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
                        Portfolio folders contain work and job-related items and accomplishments. They include:
                    </p>


                    <?php /*
                    <ul class="menu-list" style="max-width: 20em;">

                        @foreach ($portfolios as $portfolio)

                            <li>{{ $portfolio->plural }}</li>

                        @endforeach

                    </ul>
                    */ ?>
                </div>
            </div>

        </div>

    </div>


@endsection
