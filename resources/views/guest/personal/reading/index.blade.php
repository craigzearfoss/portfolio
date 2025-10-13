@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? 'Readings',
    'breadcrumbs' => [
        [ 'name' => 'Home',     'href' => route('guest.homepage')],
        [ 'name' => 'Personal', 'href' => route('guest.personal.index') ],
        [ 'name' => 'Readings']
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <?php /*
    <div class="search-container card p-2 pb-0 mb-1">
        <form id="searchForm" action="{{ route('guest.personal.reading.index') }}" method="get">
            <div class="control">
                @include('admin.components.form-select', [
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
                            'href'  => route('guest.personal.reading.show', $reading->slug),
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
