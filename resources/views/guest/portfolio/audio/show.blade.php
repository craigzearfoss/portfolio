@extends('guest.layouts.default', [
    'title' => $title ?? 'Audio: ' . $audio->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Audio ',    'href' => route('guest.portfolio.audio.index') ],
        [ 'name' => $audio->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.personal.audio.index') ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $audio->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $audio->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'parent',
            'value' => !empty($audio->parent)
                ? view('admin.components.link', [
                        'name' => $audio->parent['name'],
                        'href' => route('admin.portfolio.audio.show', $audio->parent)
                    ])
                : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $audio->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $audio->summary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'full episode',
            'checked' => $audio->full_episode
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'clip',
            'checked' => $audio->clip
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'podcast',
            'checked' => $audio->podcast
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'source recording',
            'checked' => $audio->source_recording
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($audio->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $audio->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $audio->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $audio->credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'show',
            'value' => $audio->show
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $audio->location
        ])

        @include('admin.components.show-row', [
            'name'   => 'embed',
            'value'  => $audio->embed,
        ])

        @include('admin.components.show-row', [
            'name'  => 'audio url',
            'value' => $audio->audio_url,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $audio->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $audio->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $audio->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($audio->description ?? '')
        ])

    </div>

@endsection
