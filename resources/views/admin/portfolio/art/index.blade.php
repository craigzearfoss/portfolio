@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Art';

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index',
                                                                    !empty($owner) ? [ 'owner_id'=>$owner->id ] : []
                                                                   )];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Art' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'art', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Art',
                                                               'href' => route('admin.portfolio.art.create',
                                                                               !empty($owner) ? [ 'owner_id'=>$owner->id ] : []
                                                                              )])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.art.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates featured art.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>artist</th>
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
                        <th>artist</th>
                        <th>year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                    @forelse ($arts as $art)

                        <tr data-id="{{ $art->id }}">
                            @if($admin->root)
                                <td data-field="owner.username" style="white-space: nowrap;">
                                    {{ $art->owner->username }}
                                </td>
                            @endif
                            <td data-field="name">
                                {!! $art->name !!}{!! !empty($art->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                            </td>
                            <td data-field="artist">
                                {!! $art->artist !!}
                            </td>
                            <td data-field="year">
                                {!! $art->year !!}
                            </td>
                            <td data-field="public" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $art->public ])
                            </td>
                            <td data-field="disabled" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $art->disabled ])
                            </td>
                            <td class="is-1">

                                <div class="action-button-panel">

                                    @if(canRead(PermissionEntityTypes::RESOURCE, $art, $admin))
                                        @include('admin.components.link-icon', [
                                            'title' => 'show',
                                            'href'  => route('admin.portfolio.art.show', $art),
                                            'icon'  => 'fa-list'
                                        ])
                                    @endif

                                    @if(canUpdate(App\Enums\PermissionEntityTypes::RESOURCE, $art, $admin))
                                        @include('admin.components.link-icon', [
                                            'title' => 'edit',
                                            'href'  => route('admin.portfolio.art.edit', $art),
                                            'icon'  => 'fa-pen-to-square'
                                        ])
                                    @endif

                                    @if (!empty($art->link))
                                        @include('admin.components.link-icon', [
                                            'title'  => !empty($art->link_name) ? $art->link_name : 'link',
                                            'href'   => $art->link,
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

                                    @if(canDelete(PermissionEntityTypes::RESOURCE, $art, $admin))
                                        <form class="delete-resource" action="{!! route('admin.portfolio.art.destroy', $art) !!}" method="POST">
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
                            <td colspan="{{ $admin->root ? '7' : '6' }}">There is no art.</td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

    @endsection
