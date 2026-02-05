@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Audio',      'href' => route('admin.portfolio.audio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Audio',      'href' => route('admin.portfolio.audio.index') ];
    }
    $breadcrumbs[] = [ 'name' => $audio->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate($audio, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.audio.edit', $audio)])->render();
    }
    if (canCreate('audio', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Audio', 'href' => route('admin.portfolio.audio.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.audio.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Audio: ' . $audio->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $audio->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $audio->owner->username
            ])
        @endif

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
                        'name' => $audio->parent['name'] ?? '',
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
            'name'   => !empty($audio->link_name) ? $audio->link_name : 'link',
            'href'   => $audio->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $audio->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $audio->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $audio,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $audio,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($audio->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($audio->updated_at)
        ])

    </div>

@endsection
