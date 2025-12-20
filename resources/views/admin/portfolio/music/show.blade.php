@php
    $buttons = [];
    if (canUpdate($music, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.music.edit', $music) ];
    }
    if (canCreate($music, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'href' => route('admin.portfolio.music.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.music.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : ''),
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Music',           'href' => route('admin.portfolio.music.index') ],
        [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $music->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $music->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($music->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => htmlspecialchars($music->artist)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $music->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'parent',
            'value' => !empty($music->parent)
                ? view('admin.components.link', [
                        'name' => htmlspecialchars($music->parent->name),
                        'href' => route('admin.portfolio.music.show', $music->parent)
                    ])
                : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $music->summary
        ])

        <div class="columns">
            <div class="column is-2"><strong>children</strong>:</div>
            <div class="column is-10 pl-0">
                @if(!empty($music->children))
                    <ol>
                        @foreach($music->children as $child)
                            <li>
                                @include('admin.components.link', [
                                    'name' => htmlspecialchars($child->name),
                                    'href' => route('admin.portfolio.music.show', $child)
                                ])
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'collection',
            'checked' => $music->collection
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'track',
            'checked' => $music->track
        ])

        @include('admin.components.show-row', [
            'name'  => 'label',
            'value' => $music->label
        ])

        @include('admin.components.show-row', [
            'name'  => 'catalog number',
            'value' => $music->catalog_number
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $music->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'release_date',
            'label' => 'release date',
            'value' => longDate($music->release_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'embed',
            'value' => $music->embed
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'audio url',
            'href'   => $music->audio_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($music->notes))
        ])

        @include('admin.components.show-row-link', [
            'name'   => $music->link_name ?? 'link',
            'href'   => $music->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($music->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $music->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $music,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $music,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($music->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($music->updated_at)
        ])

    </div>

@endsection
