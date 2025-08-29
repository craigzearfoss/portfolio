@extends('admin.layouts.default', [
    'title' => 'Portfolio',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Portfolio']
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        <div class="card m-4">

            <div class="card-head p-4">
                <h1>Portfolios</h1>
            </div>

            <div class="card-body p-4">

                <ul>
                    @foreach ($portfolioTypes as $portfolioType)
                        <li><a href="{{ route('admin.portfolio.'.$portfolioType->type.'.index') }}">{{ $portfolioType->name }}</a></li>
                    @endforeach
                </ul>

            </div>

        </div>

    </div>

@endsection
