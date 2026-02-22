@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Music: ' . $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Music',      'href' => route('admin.portfolio.music.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Music',      'href' => route('admin.portfolio.music.index') ];
    }
    $breadcrumbs[] = [ 'name' => $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '') ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $music, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.music.edit', $music)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'music', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Music', 'href' => route('admin.portfolio.music.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.music.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $music->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $music->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $music->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'artist',
                'value' => $music->artist
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $music->slug
            ])

            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($music->parent)
                    ? view('admin.components.link', [
                            'name' => $music->parent->name ?? '',
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
                                        'name' => $child->name,
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
                'value' => $music->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => !empty($music->link_name) ? $music->link_name : 'link',
                'href'   => $music->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $music->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $music->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $music,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
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
    </div>

@endsection
