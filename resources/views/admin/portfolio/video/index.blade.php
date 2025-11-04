@extends('admin.layouts.default', [
    'title' => 'Video',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Video' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Video', 'href' => route('admin.portfolio.video.create') ],
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
                <th class="has-text-centered">featured</th>
                <th>year</th>
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
                <th>year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($videos as $video)

                <tr data-id="{{ $video->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $video->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $video->name }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $video->featured ])
                    </td>
                    <td data-field="year">
                        {{ $video->year }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $video->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $video->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.video.destroy', $video->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.video.show', $video->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.video.edit', $video->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($video->link))
                                <a title="{{ !empty($video->link_name) ? $video->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $video->link }}"
                                   target="_blank"
                                >
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
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no videos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $videos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
