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

        <div class="card">
            <div class="card-body p-4">
                <h1>Portfolio</h1>
            </div>
        </div>

    </div>

@endsection
