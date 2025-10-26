@extends('guest.layouts.default', [
    'title' => $title ?? 'Personal Stuff',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => $title ?? 'Personal Stuff' ],
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
                        Personal folders contain items of personal interest and non career-related accomplishments. They include:
                    </p>
                    <ul class="menu-list" style="max-width: 20em;">

                        @foreach ($personals as $personal)

                            <li>{{ $personal->plural }}</li>

                        @endforeach

                    </ul>
                </div>
            </div>

        </div>

</div>

@endsection
