@php
    $buttons = [];
    if (canCreate('link', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Link', 'href' => route('admin.portfolio.link.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Links',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Links' ],
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
                <th class="has-text-centered">featured</th>
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
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($links as $link)

                <tr data-id="{{ $link->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $link->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $link->name !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->featured ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.link.destroy', [$admin, $link->id]) !!}" method="POST">

                            @if(canRead($link))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.link.show', [$admin, $link->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($link))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.link.edit', [$admin, $link->id]),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($link->url))
                                @include('admin.components.link-icon', [
                                    'title'  => 'open link in new window',
                                    'href'   => $link->url,
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

                            @if (!empty($link->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($link->link_name) ? $link->link_name : 'link',
                                    'href'   => $link->link,
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

                            @if(canDelete($link))
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
                    <td colspan="{{ isRootAdmin() ? '6' : '5' }}">There are no links.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $links->links('vendor.pagination.bulma') !!}

    </div>

@endsection
