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
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>title</th>
                <th>author</th>
                <th class="has-text-centered">fiction</th>
                <th class="has-text-centered">nonfiction</th>
                <th class="has-text-centered">publication year</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wishlist</th>
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
                <th>author</th>
                <th class="has-text-centered">fiction</th>
                <th class="has-text-centered">nonfiction</th>
                <th class="has-text-centered">publication year</th>
                <th class="has-text-centered">paper</th>
                <th class="has-text-centered">audio</th>
                <th class="has-text-centered">wishlist</th>
                <th class="has-text-centered">featured</th>
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
                        <td data-field="admin.username">
                            @if(!empty($reading->admin))
                                @include('admin.components.link', [
                                    'name' => $reading->admin['username'],
                                    'url'  => route('admin.admin.show', $reading->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="title">
                        {{ $reading->title }}
                    </td>
                    <td data-field="author">
                        {{ $reading->author }}
                    </td>
                    <td data-field="fiction" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->fiction ])
                    </td>
                    <td data-field="nonfiction" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->nonfiction ])
                    </td>
                    <td data-field="publication_year" class="has-text-centered">
                        {{ $reading->publication_year }}
                    </td>
                    <td data-field="paper" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->paper ])
                    </td>
                    <td data-field="audio" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->audio ])
                    </td>
                    <td data-field="wishlist" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->wishlist ])
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->featured ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reading->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.reading.destroy', $reading->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.reading.show', $reading->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.reading.edit', $reading->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($reading->link))
                                <a title="{{ !empty($reading->link_name) ? $reading->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $reading->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '13' : '12' }}">There are no readings.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $readings->links('vendor.pagination.bulma') !!}

    </div>

@endsection
