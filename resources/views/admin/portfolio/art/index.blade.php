@extends('admin.layouts.default', [
    'title' => 'Art',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Art' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Art', 'url' => route('admin.portfolio.art.create') ],
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
            <th>artist</th>
            <th>year</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
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
            <th>artist</th>
            <th>year</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($arts as $art)

            <tr>
                <td class="py-0">
                    {{ $art->name }}
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->professional ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->personal ])
                </td>
                <td class="py-0 text-center">
                    {{ $art->artist }}
                </td>
                <td class="py-0 text-center">
                    {{ $art->year }}
                </td>
                <td class="py-0 text-center">
                    {{ $art->sequence }}
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->public ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->readonly ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->root ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $art->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.art.destroy', $art->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.art.show', $art->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.art.edit', $art->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($art->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $art->link }}"
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
                <td colspan="11">There is no art.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $arts->links('vendor.pagination.bulma') !!}

@endsection
