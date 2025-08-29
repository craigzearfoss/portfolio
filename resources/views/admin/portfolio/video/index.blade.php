@extends('admin.layouts.default', [
    'title' => 'Videos',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Videos' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Video', 'url' => route('admin.portfolio.video.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>year</th>
            <th>credit</th>
            <th>location</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th>year</th>
            <th>credit</th>
            <th>location</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($videos as $video)

            <tr>
                <td>
                    {{ $video->name }}
                </td>
                <td>
                    {{ $video->year }}
                </td>
                <td>
                    {{ $video->credit }}
                </td>
                <td>
                    {{ $video->location }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $video->public ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $video->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.video.destroy', $video->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.video.show', $video->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.video.edit', $video->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($video->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $video->link }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
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
                <td colspan="7">There are no videos.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $videos->links('vendor.pagination.bulma') !!}

@endsection
