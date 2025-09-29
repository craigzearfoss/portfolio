@extends('admin.layouts.default', [
    'title' => 'Music',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Music' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'url' => route('admin.portfolio.music.create') ],
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
                <th>name</th>
                <th>artist</th>
                <th class="has-text-centered">featured</th>
                <th>year</th>
                <th>label</th>
                <th>cat#</th>
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
                <th>label</th>
                <th>cat#</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($musics as $music)

                <tr data-id="{{ $music->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $music->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $music->name }}
                    </td>
                    <td data-field="artist">
                        {{ $music->artist }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->featured ])
                    </td>
                    <td data-field="year">
                        {{ $music->year }}
                    </td>
                    <td data-field="label">
                        {{ $music->label }}
                    </td>
                    <td data-field="catalog_number">
                        {{ $music->catalog_number }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.music.destroy', $music->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.music.show', $music->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.music.edit', $music->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($music->link))
                                <a title="{{ !empty($music->link_name) ? $music->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $music->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There is no music.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $musics->links('vendor.pagination.bulma') !!}

    </div>

@endsection
