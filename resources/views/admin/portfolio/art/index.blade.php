@php
    $buttons = [];
    if (canCreate('art', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Art', 'href' => adminRoute('admin.portfolio.art.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Art',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => adminRoute('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => adminRoute('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => adminRoute('admin.portfolio.index') ],
        [ 'name' => 'Art' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="card p-4">

            <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                <thead>
                <tr>
                    @if(isRootAdmin())
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>artist</th>
                    <th class="has-text-centered">featured</th>
                    <th>year</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    @if(isRootAdmin())
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>artist</th>
                    <th class="has-text-centered">featured</th>
                    <th>year</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($arts as $art)

                    <tr data-id="{{ $art->id }}">
                        @if(isRootAdmin())
                            <td data-field="owner.username">
                                {{ $art->owner->username }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $art->name !!}
                        </td>
                        <td data-field="artist">
                            {!! $art->artist !!}
                        </td>
                        <td data-field="featured" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $art->featured ])
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
                        <td class="is-1" style="white-space: nowrap;">

                            <form action="{!! adminRoute('admin.portfolio.art.destroy', [$admin, $art->id]) !!}" method="POST">

                                @if(canRead($art))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => adminRoute('admin.portfolio.art.show', [$admin, $art->id]),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($art))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => adminRoute('admin.portfolio.art.edit', [$admin, $art->id]),
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

                                @if(canDelete($art))
                                    @csrf
                                    @method('DELETE')
                                    @include('admin.components.button-icon', [
                                        'title' => 'delete',
                                        'class' => 'delete-btn',
                                        'icon'  => 'fa-trash'
                                    ])
                                @endif

                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There is no art.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $arts->links('vendor.pagination.bulma') !!}

        </div>

    @endsection
