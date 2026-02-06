@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
        [ 'name' => 'Readings' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' readings',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($owner->demo)
        @include('guest.components.disclaimer')
    @endif

    <?php /*
    <div class="search-container card p-2 pb-0 mb-1">
        <form id="searchForm" action="{{ route('guest.personal.reading.index') }}" method="get">
            <div class="control">
                @include('guest.components.form-select', [
                    'name'     => 'author',
                    'value'    => Request::get('author'),
                    'list'     => \App\Models\Personal\Reading::listOptions([], 'author', 'author', true, false, ['author', 'asc']),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
        </form>
    </div>
    */ ?>

    <div class="show-container card p-4">

        {!! $readings->links('vendor.pagination.bulma') !!}

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wish list</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wish list</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($readings as $reading)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $reading->title,
                            'href'  => route('guest.personal.reading.show', [$owner, $reading->slug]),
                            'class' => $reading->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {{ $reading->author }}
                    </td>
                    <td class="has-text-centered">
                        {{ $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction' : '') }}
                    </td>
                    <td class="has-text-centered">
                        @include('guest.components.checkmark', [ 'checked' => $reading->paper ])
                    </td>
                    <td class="has-text-centered">
                        @include('guest.components.checkmark', [ 'checked' => $reading->audio ])
                    </td>
                    <td class="has-text-centered">
                        @include('guest.components.checkmark', [ 'checked' => $reading->wishlist ])
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $readings->links('vendor.pagination.bulma') !!}

    </div>

@endsection
