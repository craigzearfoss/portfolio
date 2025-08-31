@extends('admin.layouts.default', [
    'title' => 'Academies',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Academy', 'url' => route('admin.portfolio.academy.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
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
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($academies as $academy)

            <tr>
                <td class="py-0">
                    {{ $academy->name }}
                </td>
                <td class="py-0 text-center">
                    {{ $academy->sequence }}
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $academy->public ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $academy->readonly ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $academy->root ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $academy->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.academy.destroy', $academy->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.academy.show', $academy->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.academy.edit', $academy->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($academy->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $academy->website }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
                            </a>
                        @else
                            <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
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
                <td colspan="7">There are no academies.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $academies->links('vendor.pagination.bulma') !!}

@endsection
