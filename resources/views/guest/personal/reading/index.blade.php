@php
    use App\Models\Personal\Reading;

    $title    = $pageTitle ?? $owner->name . ' readings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Personal',   'href' => route('guest.personal.index', $owner) ],
            [ 'name' => 'Readings' ],
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    @include('guest.components.search-panel.reading', [ 'action' => route('guest.personal.reading.index', $owner) ])

    <?php /*
    <div class="search-container card p-2 pb-0 mb-1">
        <form id="searchForm" action="{{ route('guest.personal.reading.index', request()->all()) }}" method="get">
            <div class="control">
                @include('guest.components.form-select', [
                    'name'     => 'author',
                    'value'    => Request::get('author'),
                    'list'     => new Reading()->listOptions([], 'author', 'author', true, false, ['author', 'asc']),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
        </form>
    </div>
    */ ?>

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>title</th>
                        <th>author</th>
                        <th class="has-text-centered hide-at-480">type</th>
                        <th class="has-text-centered hide-at-600">paper</th>
                        <th class="has-text-centered hide-at-600">audio</th>
                        <th class="has-text-centered hide-at-600">wish list</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>title</th>
                        <th>author</th>
                        <th class="has-text-centered hide-at-480">type</th>
                        <th class="has-text-centered hide-at-600">paper</th>
                        <th class="has-text-centered hide-at-600">audio</th>
                        <th class="has-text-centered hide-at-600">wish list</th>
                    </tr>
                    </tfoot>
                @endif

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
                        <td class="has-text-centered hide-at-480">
                            {{ $reading->fiction ? 'fiction' : ($reading->nonfiction ? 'nonfiction' : '') }}
                        </td>
                        <td class="has-text-centered hide-at-600">
                            @include('guest.components.checkmark', [ 'checked' => $reading->paper ])
                        </td>
                        <td class="has-text-centered hide-at-600">
                            @include('guest.components.checkmark', [ 'checked' => $reading->audio ])
                        </td>
                        <td class="has-text-centered hide-at-600">
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

            @if($pagination_bottom)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
