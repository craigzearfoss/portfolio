@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Video: ' . $video->name;
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
        $breadcrumbs[] = [ 'name' => 'Videos',     'href' => route('admin.portfolio.video.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Videos',     'href' => route('admin.portfolio.video.index') ];
    }
    $breadcrumbs[] = [ 'name' => $video->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $video, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.video.edit', $video)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'video', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Video', 'href' => route('admin.portfolio.video.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.video.index')])->render();
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
                'value' => $video->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $video->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $video->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $video->slug
            ])

            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($video->parent)
                    ? view('admin.components.link', [
                            'name' => $video->parent->name ?? '',
                            'href' => route('admin.portfolio.video.show', $video->parent)
                        ])
                    : ''
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'featured',
                'checked' => $video->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $video->summary
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'full episode',
                'checked' => $video->full_episode
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'clip',
                'checked' => $video->clip
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'public access',
                'checked' => $video->public_access
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'source recording',
                'checked' => $video->source_recording
            ])

            @include('admin.components.show-row', [
                'name'  => 'date',
                'value' => longDate($video->date)
            ])

            @include('admin.components.show-row', [
                'name'  => 'year',
                'value' => $video->year
            ])

            @include('admin.components.show-row', [
                'name'  => 'company',
                'value' => $video->company
            ])

            @include('admin.components.show-row', [
                'name'  => 'credit',
                'value' => $video->credit
            ])

            @include('admin.components.show-row', [
                'name'  => 'show',
                'value' => $video->show
            ])

            @include('admin.components.show-row', [
                'name'  => 'location',
                'value' => $video->location
            ])

            @include('admin.components.show-row', [
                'name'   => 'embed',
                'value'  => $video->embed,
            ])

            @include('admin.components.show-row', [
                'name'  => 'video url',
                'value' => $video->video_url,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $video->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => !empty($video->link_name) ? $video->link_name : '',
                'href'   => $video->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $video->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $video->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $video,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $video,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($video->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($video->updated_at)
            ])

        </div>
    </div>

@endsection
