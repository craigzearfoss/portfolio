
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
                <th>abbreviation</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($industries as $industry)

                <tr data-id="{{ $industry->id }}">
                    <td data-field="name">
                        {{ $industry->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $industry->abbreviation }}
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.industry.destroy', $industry->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.industry.show', $industry->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.industry.edit', $industry->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($industry->link))
                                <a title="{{ !empty($industry->link_name) ? $industry->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $industry->link }}"
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
                                <i class="fa-solid fa-trash"></i>{{-- Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">There are no industries.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $industries->links('vendor.pagination.bulma') !!}

    </div>

@endsection
