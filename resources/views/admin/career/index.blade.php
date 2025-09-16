@extends('admin.layouts.default', [
    'title' => 'Career',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Career']
    ],
    'buttons' => [],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card m-4">

        <div class="card-head p-4">
            <h1>Careers</h1>
        </div>

        <div class="card-body p-4">

            <ul>
                @foreach ($careerTypes as $careerType)
                    <li><a href="{{ route('admin.career.'.$careerType->type.'.index') }}">{{ $careerType->name }}</a></li>
                @endforeach
            </ul>

        </div>

    </div>

@endsection
