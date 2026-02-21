@php
    use App\Enums\PermissionEntityTypes;

    $title = $pageTitle ?? 'Music';
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
    $breadcrumbs[] = [ 'name' => 'Music' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'music', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Music', 'href' => route('admin.portfolio.music.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.music.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured music.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>artist</th>
                    <th>year</th>
                    <th>label</th>
                    <th>cat#</th>
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
                        <th>artist</th>
                        <th>year</th>
                        <th>label</th>
                        <th>cat#</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($musics as $music)

                    <tr data-id="{{ $music->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $music->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $music->name !!}{!! !empty($music->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="artist">
                            {!! $music->artist !!}
                        </td>
                        <td data-field="year">
                            {!! $music->year !!}
                        </td>
                        <td data-field="label">
                            {!! $music->label !!}
                        </td>
                        <td data-field="catalog_number">
                            {!! $music->catalog_number !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $music->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $music->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $music, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.music.show', $music),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $music, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.music.edit', $music),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($music->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($music->link_name) ? $music->link_name : 'link',
                                        'href'   => $music->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $music, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.music.destroy', $music) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '9' : '8' }}">There is no music.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
