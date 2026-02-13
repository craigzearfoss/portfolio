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
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Publications' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'publication', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Publication', 'href' => route('admin.portfolio.publication.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Publications',
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

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.publication.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $publications->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>title</th>
                <th class="has-text-centered">featured</th>
                <th>publication<br>name</th>
                <th>publisher</th>
                <th class="has-text-centered">year</th>
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
                    <th>title</th>
                    <th class="has-text-centered">featured</th>
                    <th>publication<br>name</th>
                    <th>publisher</th>
                    <th class="has-text-centered">year</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($publications as $publication)

                <tr data-id="{{ $publication->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $publication->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="title">
                        {!! $publication->title !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->featured ])
                    </td>
                    <td data-field="publication_name">
                        {!! $publication->publication !!}
                    </td>
                    <td data-field="publisher">
                        {!! $publication->publisher !!}
                    </td>
                    <td data-field="year">
                        {!! $publication->year !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $publication, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.publication.show', $publication),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $publication, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.publication.edit', $publication),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($publication->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($publication->link_name) ? $publication->link_name : 'link',
                                    'href'   => $publication->link,
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $publication, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.publication.destroy', $publication) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '9' : '8' }}">There are no publications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $publications->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
