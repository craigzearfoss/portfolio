
@extends('admin.layouts.default', [
    'title' => 'Industries',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Industries' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Industry', 'url' => route('admin.career.industry.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>abbreviation</th>
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
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($industries as $industry)

            <tr>
                <td>
                    {{ $industry->name }}
                </td>
                <td>
                    {{ $industry->abbreviation }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $industry->public ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $industry->readonly ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $industry->root ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $industry->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.career.industry.destroy', $industry->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.industry.show', $industry->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.industry.edit', $industry->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($industry->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $industry->link }}"
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
                <td colspan="7">There are no industries.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $industries->links('vendor.pagination.bulma') !!}

@endsection
