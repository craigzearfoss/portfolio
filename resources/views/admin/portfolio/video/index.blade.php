@php
    use App\Models\Portfolio\Video;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Video';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Video';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Videos' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Video::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Video',
                                                                  'href' => route('admin.portfolio.video.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-video', [ 'owner_id'   => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 90em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.video.export', request()->except([ 'page' ])),
                'filename' => 'videos_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($videos->total()) }} {{ ($videos->total() === 1) ? 'video' : 'videos' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured video. <span class="sample-color-box-light-gray"></span> indicates the video is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'video_year|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'show',
                                'sort'  => 'show|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'company',
                                'sort'  => 'company|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($videos as $video)

                    <tr data-id="{{ $video->id }}" {!! $video->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $video->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $video->owner->username,
                                    'href'  => route('admin.system.admin.show', $video->owner),
                                    'class' => $video->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $video->name . (!empty($video->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href'  => route('admin.portfolio.video.show', $video),
                                'class' => $video->is_disabled ? [ 'disabled-text' ] : []
                            ])
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'portfolio.video', 'data-id' => $video->id ]
                           ])
                        </td>
                        <td data-field="video_year" style="white-space: nowrap;">
                            {{ $video->video_year }}
                        </td>
                        <td data-field="show" style="white-space: nowrap;">
                            {{ $video->show }}
                        </td>
                        <td data-field="company" style="white-space: nowrap;">
                            {{ $video->company }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $video->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $video->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($video, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.video.show', ownerParams($video, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($video, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.video.edit', ownerParams($video, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($video->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($video->link_name) ? $video->link_name : 'link',
                                        'href'   => $video->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if (canDelete($video, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.video.destroy', $video) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No videos found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
