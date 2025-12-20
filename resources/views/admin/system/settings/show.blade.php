@extends('admin.layouts.default', [
    'title' => 'Settings',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Settings' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.message.create') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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
