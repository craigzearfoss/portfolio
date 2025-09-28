@extends('admin.layouts.default', [
    'title' => 'User Teams',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.user.index') ],
        [ 'name' => 'User Teams' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New User Team', 'url' => route('admin.user-team.create') ],
        [ 'name' => '<i class="fa fa-list"></i> User Groups',       'url' => route('admin.user-group.index') ],
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
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($userTeams as $userTeam)

                <tr data-id="{{ $userTeam->id }}">
                    <td data-field="name">
                        {{ $userTeam->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $userTeam->abbreviation }}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userTeam->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.user-team.destroy', $userTeam->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.user-team.show', $userTeam->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.user-team.edit', $userTeam->id) }}">
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
                    <td colspan="7">There are no user teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $userTeams->links('vendor.pagination.bulma') !!}

    </div>

@endsection
