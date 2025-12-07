@extends('admin.layouts.default', [
    'title' => 'Admin Groups',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admin Groups' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Group', 'href' => route('admin.system.admin-group.create') ],
        [ 'name' => '<i class="fa fa-list"></i> Admin Teams',         'href' => route('admin.system.admin-team.index') ],
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
                <th>team</th>
                <th>abbreviation</th>
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
                <th>team</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($adminGroups as $adminGroup)

                <tr data-id="{{ $adminGroup->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $adminGroup->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $adminGroup->name }}
                    </td>
                    <td data-field="team.name">
                        {{ $adminGroup->team['name'] ?? '' }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $adminGroup->abbreviation }}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminGroup->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.system.admin-group.destroy', $adminGroup->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.system.admin-group.show', $adminGroup->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.system.admin-group.edit', $adminGroup->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '6' : '5' }}">There are no admin groups.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $adminGroups->links('vendor.pagination.bulma') !!}

    </div>

@endsection
