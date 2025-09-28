@extends('admin.layouts.default', [
    'title' => 'Admin Teams',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'href' => route('admin.admin.index') ],
        [ 'name' => 'Admin Teams' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Admin Team', 'url' => route('admin.admin-team.create') ],
        [ 'name' => '<i class="fa fa-list"></i> Admin Groups',       'url' => route('admin.admin-group.index') ],
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
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($adminTeams as $adminTeam)

                <tr data-id="{{ $adminTeam->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $adminTeam->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $adminTeam->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $adminTeam->abbreviation }}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminTeam->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.admin-team.destroy', $adminTeam->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin-team.show', $adminTeam->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.admin-team.edit', $adminTeam->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

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
                    <td colspan="{{ isRootAdmin() ? '5' : '4' }}">There are no admin teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $adminTeams->links('vendor.pagination.bulma') !!}

    </div>

@endsection
