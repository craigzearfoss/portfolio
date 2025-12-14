@extends('admin.layouts.default', [
    'title' => 'Units',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units' ],
    ],
    'buttons' => [
        canCreate('unit')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Unit', 'href' => route('admin.personal.unit.create') ]]
            : [],
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
                <th>system</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>system</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($units as $unit)

                <tr data-id="{{ $unit->id }}">
                    <td data-field="name">
                        {{ $unit->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $unit->abbreviation }}
                    </td>
                    <td data-field="system" class="has-text-centered">
                        {{ $unit->system }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.personal.unit.destroy', $unit->id) }}" method="POST">

                            @if(canRead($unit))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.unit.show', $unit->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canRead($unit))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.unit.edit', $unit->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($unit->link))
                                <a title="{{ !empty($unit->link_name) ? $unit->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $unit->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($unit))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no units.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $units->links('vendor.pagination.bulma') !!}

    </div>

@endsection
