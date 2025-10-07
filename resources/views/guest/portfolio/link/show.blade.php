@extends('guest.layouts.default', [
    'title' => $title ?? 'Link: ' . $link->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Course',    'href' => route('guest.portfolio.link.index') ],
        [ 'name' => $link->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.portfolio.link.index') ],
    ],
    'errors'  => $errors->any()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container ard p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $link->name
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $link->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $link->summary
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'url',
            'href'    => $link->url,
            'target' => '_blank'
        ])

        @if(!empty($link))
            @include('admin.components.show-row-link', [
                'name'   => !empty($link->link_name) ? $link->link_name : 'link',
                'href'   => $link->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($link->description ?? '')
        ])

    </div>

@endsection
