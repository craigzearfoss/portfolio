@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Dictionary']
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        <div class="card">
            <div class="card-body p-4">
                <h1>Dictionary</h1>
            </div>
        </div>

    </div>

@endsection
