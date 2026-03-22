@php
    $title    = $pageTitle ?? ($featuredAdmin ? $featuredAdmin->name : config('add.name'));
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if ($featuredAdmin)
        <h2 class="title p-2 mb-2">{{ $featuredAdmin->name }} Portfolio</h2>
    @else
        <h2 class="title p-2 mb-2">Welcome to {{ config('app.name') }}!</h2>
    @endif

    <div class="floating-div-container">

        @if ($featuredAdmin)
            @include('guest.components.featured-admin', [
                'featuredAdmin' => $featuredAdmin,
                'title'         => 'Featured Candidate',
            ])
        @endif

        <div class="card floating-div p-2" style="height: 500px; max-width: 40rem; overflow-y: scroll;">

            <h4 class="title is-size-5 mb-2">
                Candidates
                <span class="is-pulled-right">
                    @include('guest.components.link', [
                        'name' => 'All',
                        'href' => route('guest.admin.index')
                    ])
                </span>
            </h4>

        </div>

    </div>

    @if(config('app.include_site_intro'))
        <div class="floating-div-container" style=" max-width: 100% !important;">
            @include('guest.components.partials.site-intro')
        </div>
    @endif

@endsection
