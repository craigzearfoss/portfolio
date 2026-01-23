@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Settings',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Settings' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card pl-2 pr-2 pb-2">

            <h2 class="subtitle mt-2 mb-1">.env settings</h2>

            <code class="has-text-left">

                @foreach ($envSettings as $i=>$setting)

                    @if($i > 0)<br>@endif

                    {{$setting . PHP_EOL}}

                @endforeach

            </code>

    </div>

@endsection
