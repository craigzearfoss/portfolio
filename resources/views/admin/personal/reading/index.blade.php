@php
    $buttons = [];
    if (canCreate('ingredient', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Reading', 'href' => route('admin.personal.reading.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Readings',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Readings' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="search-container card p-2">
        <form id="searchForm" action="{{ route('admin.personal.reading.index') }}" method="get">
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

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
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
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
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
            */ ?>
            <tbody>

            @forelse ($readings as $reading)

                <tr data-id="{{ $reading->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $reading->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="title">
                        {{ $reading->title }}
                    </td>
                    <td data-field="author">
                        {{ $reading->author }}
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
                        {{ $reading->publication_year }}
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
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.personal.reading.destroy', $reading->id) }}" method="POST">

                            @if(canRead($reading))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.reading.show', $reading->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($reading))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.reading.edit', $reading->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($reading->link))
                                <a title="{{ !empty($reading->link_name) ? $reading->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $reading->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($reading))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '11' : '10' }}">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $readings->links('vendor.pagination.bulma') !!}

    </div>

@endsection
