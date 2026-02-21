@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Photography';
    $subtitle = $title;

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
    $breadcrumbs[] = [ 'name' => 'Photography' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'photo', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Photo',
                                                               'href' => route('admin.portfolio.photography.create',
                                                                               !empty($owner) ? [ 'owner_id'=>$owner->id ] : []
                                                                              )])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.photography.index') ])
    @endif

    <p class="admin-table-caption">* An asterisk indicates a featured photo.</p>

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>credit</th>
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
                        <th>credit</th>
                        <th>year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($photos as $photo)

                    <tr data-id="{{ $photo->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {!! $photo->owner->username !!}
                            </td>
                        @endif
                        <td data-field="year">
                            {!! $photo->name !!}{!! !empty($photo->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="year">
                            {!! $photo->name !!}
                        </td>
                        <td data-field="year">
                            {!! $photo->year !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $photo->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $photo->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $photo, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.photography.show', $photo),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $photo, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.photography.edit', $photo),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($photo->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($photo->link_name) ? $photo->link_name : 'link',
                                        'href'   => $photo->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $photo, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.photography.destroy', $photo) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '7' : '6' }}">There is are no photos.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
