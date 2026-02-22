@php
    $title    = $pageTitle ?? 'Settings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Settings' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <h2 class="subtitle mt-2 mb-1">.env settings</h2>

            <code class="has-text-left">

                @foreach ($envSettings as $i=>$setting)

                    @if($i > 0)<br>@endif

                    {{$setting . PHP_EOL}}

                @endforeach

            </code>

        </div>
    </div>

@endsection
