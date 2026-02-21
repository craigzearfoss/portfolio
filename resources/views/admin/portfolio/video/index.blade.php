@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Video';
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
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Videos' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'video', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Video', 'href' => route('admin.portfolio.video.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.video.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured award.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>year</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($videos as $video)

                    <tr data-id="{{ $video->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $video->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $video->name !!}{!! !empty($video->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="year">
                            {!! $video->year !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $video->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $video->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $video, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.video.show', $video),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $video, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.video.edit', $video),
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $video, $admin))
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
                        <td colspan="{{ $admin->root ? '6' : '5' }}">There are no videos.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $videos->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
