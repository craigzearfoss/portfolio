@extends('admin.layouts.default', [
    'title' => 'Links',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Links' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Link', 'url' => route('admin.portfolio.link.create') ],
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
                <th>name</th>
                <th class="has-text-centered">sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th class="has-text-centered">sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($links as $link)

                <tr>
                    <td class="py-0">
                        {{ $link->name }}
                    </td>
                    <td class="py-0">
                        {{ $link->sequence }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $link->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.link.destroy', $link->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.link.show', $link->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.link.edit', $link->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($link->url))
                                <a title="url" class="button is-small px-1 py-0" href="{{ $link->url }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- url--}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- url --}}
                                </a>
                            @endif

                            @if (!empty($link->link))
                                <a title="{{ !empty($link->link_name) ? $link->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $link->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no links.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $links->links('vendor.pagination.bulma') !!}

    </div>

@endsection
