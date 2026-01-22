@php
    $buttons = [];
    if (canCreate('ingredient', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Reading', 'href' => route('admin.personal.reading.create', $owner)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Readings',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Readings' ],
    ],
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

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! route('admin.personal.reading.index', $owner) !!}" method="get">
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'author',
                    'value'    => Request::get('author'),
                    'list'     => \App\Models\Personal\Reading::listOptions([], 'author', 'author', true, false, ['author', 'asc']),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
            <div class="control">
                @include('admin.components.form-checkbox', [
                    'name'     => 'fiction',
                    'value'    => 1,
                    'checked'  => boolval(Request::get('fiction') ?? false),
                    'nohidden' => true,
                    'onclick'  => "document.getElementById('searchForm').submit()"
                ])
                @include('admin.components.form-checkbox', [
                   'name'     => 'nonfiction',
                   'value'    => 1,
                   'checked'  => boolval(Request::get('nonfiction') ?? false),
                   'nohidden' => true,
                   'onclick'  => "document.getElementById('searchForm').submit()"
               ])
            </div>
            <div class="control">
                @include('admin.components.form-checkbox', [
                    'name'     => 'paper',
                    'value'    => 1,
                    'checked'  => boolval(Request::get('paper') ?? false),
                    'nohidden' => true,
                    'onclick'  => "document.getElementById('searchForm').submit()"
                ])
                @include('admin.components.form-checkbox', [
                   'name'     => 'audio',
                   'value'    => 1,
                   'checked'  => boolval(Request::get('audio') ?? false),
                   'nohidden' => true,
                   'onclick'  => "document.getElementById('searchForm').submit()"
               ])
            </div>
            <div class="control">
                @include('admin.components.form-checkbox', [
                    'name'     => 'wishlist',
                    'value'    => 1,
                    'checked'  => boolval(Request::get('wishlist') ?? false),
                    'nohidden' => true,
                    'onclick'  => "document.getElementById('searchForm').submit()"
                ])
            </div>
        </form>
    </div>

    <div class="show-container card p-4">

        @if($pagination_top)
            {!! $readings->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">featured</th>
                <th>type</th>
                <th class="has-text-centered">publication year</th>
                <th>media</th>
                <th class="has-text-centered">wishlist</th>
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
                    <th>author</th>
                    <th class="has-text-centered">featured</th>
                    <th>type</th>
                    <th class="has-text-centered">publication year</th>
                    <th>media</th>
                    <th class="has-text-centered">wishlist</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($readings as $reading)

                <tr data-id="{{ $reading->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $reading->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="title">
                        {!! $reading->title !!}
                    </td>
                    <td data-field="author">
                        {!! $reading->author !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->featured ])
                    </td>
                    <td data-field="fiction|nonfiction">
                        {{
                            (!empty($reading->fiction) && !empty($reading->nonfiction))
                                ? 'fiction/nonfiction'
                                : (!empty($reading->fiction) ? 'fiction' : (!empty($reading->nonfiction) ? 'nonfiction' : ''))
                        }}
                    </td>
                    <td data-field="publication_year" class="has-text-centered">
                        {!! $reading->publication_year !!}
                    </td>
                    <td data-field="paper|audio" style="white-space: nowrap;">
                        {{
                            (!empty($reading->paper) && !empty($reading->audio))
                                ? 'paper, audio'
                                : (!empty($reading->paper) ? 'paper' : (!empty($reading->audio) ? 'audio' : ''))
                        }}
                    </td>
                    <td data-field="wishlist" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->wishlist ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($reading, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.personal.reading.show', [$owner, $reading->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($reading, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.personal.reading.edit', [$owner, $reading->id]),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($reading->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($reading->link_name) ? $reading->link_name : 'link',
                                    'href'   => $reading->link,
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

                            @if(canDelete($reading, $admin))
                                <form class="delete-resource" action="{!! route('admin.personal.reading.destroy', $reading) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '11' : '10' }}">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $readings->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
