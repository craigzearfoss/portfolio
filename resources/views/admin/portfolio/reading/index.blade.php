@extends('admin.layouts.default', [
    'title' => 'Readings',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Readings' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reading', 'url' => route('admin.portfolio.reading.create') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">fiction</th>
                <th class="has-text-centered">nonfiction</th>
                <th class="has-text-centered">publication year</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wishlist</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">readonly</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>author</th>
                <th class="has-text-centered">fiction</th>
                <th class="has-text-centered">nonfiction</th>
                <th class="has-text-centered">publication year</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wishlist</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">readonly</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($readings as $reading)

                <tr>
                    <td>
                        {{ $reading->title }}
                    </td>
                    <td>
                        {{ $reading->author }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->fiction ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->nonfiction ])
                    </td>
                    <td class="has-text-centered">
                        {{ $reading->publication_year }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->paper ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->audio ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->wishlist ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->public ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->readonly ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->root ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.reading.destroy', $reading->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.reading.show', $reading->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.reading.edit', $reading->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($reading->link))
                                <a title="{{ !empty($reading->link_name) ? $reading->link_name : 'link' }}" class="button is-small px-1 py-0" href="{{ $reading->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="13">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $readings->links('vendor.pagination.bulma') !!}

    </div>

@endsection
