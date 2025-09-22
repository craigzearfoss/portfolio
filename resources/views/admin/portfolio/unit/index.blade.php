@extends('admin.layouts.default', [
    'title' => 'Units',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Units' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Unit', 'url' => route('admin.portfolio.unit.create') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
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
                <th>system</th>
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
                <th>abbreviation</th>
                <th>system</th>
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

            @forelse ($units as $unit)

                <tr>
                    <td class="py-0">
                        {{ $unit->name }}
                    </td>
                    <td class="py-0">
                        {{ $unit->abbreviation }}
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $unit->system }}
                    </td>
                    <td class="py-0 has-text-centered">
                        {{ $unit->sequence }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $unit->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $unit->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $unit->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $unit->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.unit.destroy', $unit->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.unit.show', $unit->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.unit.edit', $unit->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($unit->link))
                                <a title="{{ !empty($unit->link_name) ? $unit->link_name : 'link' }}" class="button is-small px-1 py-0" href="{{ $unit->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
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
                    <td colspan="9">There are no units.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $units->links('vendor.pagination.bulma') !!}

    </div>

@endsection
