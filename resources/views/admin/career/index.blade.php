@extends('admin.layouts.default', [
    'title' => 'Career',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Career']
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        <div class="card">
            <div class="card-body p-4">
                <h1>Career</h1>
            </div>
        </div>

    </div>

@endsection
