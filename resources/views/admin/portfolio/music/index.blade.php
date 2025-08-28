@extends('admin.layouts.default', [
    'title' => 'Music',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Music']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'url' => route('admin.portfolio.music.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($musics as $music)

            <tr>
                <td>
                    {{ $music->name }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $music->professional ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $music->personal ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $music->public ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $music->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.music.destroy', $music->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.music.show', $music->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.music.edit', $music->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

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
                <td colspan="6">There is no music.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $musics->links('vendor.pagination.bulma') !!}

@endsection
