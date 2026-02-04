@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Music',      'href' => route('guest.portfolio.music.index', $owner) ],
        [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ],
    ],
    'buttons'          => [
        view('guest.components.nav-button-back', ['href' => referer('guest.admin.portfolio.music.index', $owner)])->render(),
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

    @include('guest.components.disclaimer', [ 'value' => $music->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $music->name
        ])

        @if(!empty($music->artist))
            @include('guest.components.show-row', [
                'name'  => 'artist',
                'value' => $music->artist
            ])
        @endif

        @if(!empty($music->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => view('guest.components.link', [
                                'name' => $music->parent->name,
                                'href' => route('guest.portfolio.music.show', [$owner, $music->parent->slug])
                           ])
            ])
        @endif

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $music->featured
        ])
        */ ?>

        @if(!empty($music->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $music->summary
            ])
        @endif

        @if($music->children->count() > 0)
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($music->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child->name,
                                    'href' => route('guest.portfolio.music.show', [$owner, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @if(!empty($music->collection))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'collection',
                'checked' => $music->collection
            ])
        @endif

        @if(!empty($music->track))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'track',
                'checked' => $music->track
            ])
        @endif

        @if(!empty($music->label))
            @include('guest.components.show-row', [
                'name'  => 'label',
                'value' => $music->label
            ])
        @endif

        @if(!empty($music->catalog_number))
            @include('guest.components.show-row', [
                'name'  => 'catalog number',
                'value' => $music->catalog_number
            ])
        @endif

        @if(!empty($music->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $music->year
            ])
        @endif

        @if(!empty($music->release_date))
            @include('guest.components.show-row', [
                'name'  => 'release date',
                'value' => longDate($music->release_date)
            ])
        @endif

        @if(!empty($music->embed))
            @include('guest.components.show-row', [
                'name'  => 'embed',
                'value' => $music->embed
            ])
        @endif

        @if(!empty($music->audio_url))
            @include('guest.components.show-row-link', [
                'name'   => 'audio url',
                'href'   => $music->audio_url,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($music->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($music->link_name) ? $music->link_name : 'link',
                'href'   => $music->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($music->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($music->description)
            ])
        @endif

        @if(!empty($music->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $music->image,
                'alt'          => $music->name . (!empty($music->artist) ? ', ' . $music->artist : ''),
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug(
                    $music->name . (!empty($music->artist) ? '-by-' . $music->artist : ''),
                    $music->image
                 ),
                'image_credit' => $music->image_credit,
                'image_source' => $music->image_source,
            ])
        @endif

        @if(!empty($music->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $music->thumbnail,
                'alt'      => $music->name . (!empty($music->artist) ? ', ' . $music->artist : '') . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug(
                    $music->name . (!empty($music->artist) ? '-by-' . $music->artist : '') . '-thumbnail',
                    $music->image
                 ),
            ])
        @endif

    </div>

@endsection
