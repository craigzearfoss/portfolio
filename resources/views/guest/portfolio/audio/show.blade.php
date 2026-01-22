@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Audio: ' . $audio->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Audio',      'href' => route('guest.portfolio.audio.index', $owner) ],
        [ 'name' => $audio->name ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.audio.index', $owner)])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $audio->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $audio->name
        ])

        @if(!empty($audio->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => view('guest.components.link', [
                                'name' => $audio->parent->name,
                                'href' => route('guest.portfolio.audio.show', [$owner, $audio->parent->slug])
                           ])
            ])
        @endif

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $audio->featured
        ])
        */
        ?>

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $audio->summary ?? ''
        ])

        @if(!empty($audio->children))
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($audio->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child->name,
                                    'href' => route('guest.portfolio.audio.show', [$owner, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @if(!empty($audio->full_episode))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'full episode',
                'checked' => $audio->full_episode
            ])
        @endif

        @if(!empty($audio->clip))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'clip',
                'checked' => $audio->clip
            ])
        @endif

        @if(!empty($audio->podcast))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'podcast',
                'checked' => $audio->podcast
            ])
        @endif

        @if(!empty($audio->source_recording))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'source recording',
                'checked' => $audio->source_recording
            ])
        @endif

        @if(!empty($audio->date))
            @include('guest.components.show-row', [
                'name'  => 'date',
                'value' => longDate($audio->date)
            ])
        @endif

        @if(!empty($audio->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $audio->year
            ])
        @endif

        @if(!empty($audio->company))
            @include('guest.components.show-row', [
                'name'  => 'company',
                'value' => $audio->company
            ])
        @endif

        @if(!empty($audio->credit))
            @include('guest.components.show-row', [
                'name'  => 'credit',
                'value' => $audio->credit
            ])
        @endif

        @if(!empty($audio->show))
            @include('guest.components.show-row', [
                'name'  => 'show',
                'value' => $audio->show
            ])
        @endif

        @if(!empty($audio->location))
            @include('guest.components.show-row', [
                'name'  => 'location',
                'value' => $audio->location
            ])
        @endif

        @if(!empty($audio->embed))
            @include('guest.components.show-row', [
                'name'   => 'embed',
                'value'  => $audio->embed,
            ])
        @endif

        @if(!empty($audio->audio_url))
            @include('guest.components.show-row', [
                'name'  => 'audio url',
                'value' => $audio->audio_url,
            ])
        @endif

        @if(!empty($audio->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($audio->link_name) ? $audio->link_name : 'link',
                'href'   => $audio->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($audio->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($audio->description)
            ])
        @endif

        @if(!empty($audio->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $audio->image,
                'alt'          => $audio->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($audio->name, $audio->image),
                'image_credit' => $audio->image_credit,
                'image_source' => $audio->image_source,
            ])
        @endif

        @if(!empty($audio->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $audio->thumbnail . ' thumbnail',
                'alt'      => $audio->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($audio->name . '-thumbnail', $audio->thumbnail)
            ])
        @endif

    </div>

@endsection
