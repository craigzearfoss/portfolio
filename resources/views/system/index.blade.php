@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? (config('app.name') . ' System Dashboard');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.index') ],
        [ 'name' => 'System Dashboard' ],
    ];

    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="list is-hoverable">

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($menuItems as $menuItem)

                        <li class="list-item">
                            @include('admin.components.link', [
                                'name' => $menuItem['name'],
                                'href' => $menuItem['href'],
                                'class' => 'has-text-black',
                            ])
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>
    </div>

@endsection
