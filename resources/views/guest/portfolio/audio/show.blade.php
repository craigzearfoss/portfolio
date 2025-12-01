@extends('guest.layouts.default', [
    'title' => $title ?? 'Audio: ' . $audio->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Audio',      'href' => route('guest.admin.portfolio.audio.index', $admin) ],
        [ 'name' => $audio->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.audio.index', $admin) ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $audio->disclaimer ?? null ])

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $audio->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $audio->slug
        ])

        @if(!empty($audio->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($audio->parent)
                    ? view('guest.components.link', [
                            'name' => $audio->parent['name'],
                            'href' => route('guest.admin.portfolio.audio.show', [$admin, $audio->parent->slug])
                        ])
                    : ''
            ])
        @endif

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $audio->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $audio->summary
        ])

        @if(!empty($audio->children))
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($audio->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child['name'],
                                    'href' => route('guest.admin.portfolio.audio.show', [$admin, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

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
