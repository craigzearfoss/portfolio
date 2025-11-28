@extends('guest.layouts.default', [
    'title' => $title ?? 'Award: ' . $award->name . (!empty($award->year) ? ' - ' . $award->year : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Award',      'href' => route('guest.admin.portfolio.award.index', $admin) ],
        [ 'name' => $award->name . (!empty($award->year) ? ' - ' . $award->year : '') ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.award.index', $admin) ],
    ],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $award->name
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $award->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $award->summary
        ])

        @include('guest.components.show-row', [
            'name'    => 'year',
            'checked' => $award->year
        ])

        @include('guest.components.show-row', [
            'name'    => 'date received',
            'checked' => $award->date_received
        ])

        @include('guest.components.show-row', [
            'name'    => 'organization',
            'checked' => $award->organization
        ])

        @if(!empty($award->link))
            @include('guest.components.show-row-link', [
                'name'   => $award->link_name,
                'href'   => $award->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($award->description ?? '')
        ])

        @if(!empty($award->image))

            @include('guest.components.show-row-image', [
                'name'     => 'image',
                'src'      => $award->image,
                'alt'      => $award->name,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($award->name . (!empty($award->year) ? ' - ' . $award->year : ''), $award->image)
            ])

            @if(!empty($award->image_credit))
                @include('guest.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $award->image_credit
                ])
            @endif

            @if(!empty($award->image_source))
                @include('guest.components.show-row', [
                    'name'  => 'image source',
                    'value' => $award->image_source
                ])
            @endif

        @endif

        @if(!empty($award->thumbnail))

            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $award->thumbnail,
                'alt'      => $award->name . ', ' . (!empty($award->year) ? ' - ' . $award->year : ''),
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($award->name . (!empty($award->year) ? ' - ' . $award->year : ''), $award->thumbnail)
            ])

        @endif

    </div>

@endsection
